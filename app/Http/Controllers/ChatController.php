<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Danh sách cuộc trò chuyện
     */
    public function index()
    {
        $userId = Auth::id();
        $user = Auth::user();

        // Lấy danh sách users đã chat
        $conversations = Chat::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($chat) use ($userId) {
                return $chat->sender_id == $userId ? $chat->receiver : $chat->sender;
            })
            ->unique('id')
            ->values();

        // Nếu là customer, lấy danh sách admin để có thể bắt đầu chat
        $admins = collect();
        if ($user->isCustomer()) {
            $admins = User::where('role', 'admin')
                ->whereNotIn('id', $conversations->pluck('id'))
                ->get();
        }

        // Nếu là admin, lấy danh sách customers có thể chat
        $customers = collect();
        if ($user->isAdmin()) {
            $customers = User::where('role', 'customer')
                ->whereNotIn('id', $conversations->pluck('id'))
                ->get();
        }

        // Đếm tin nhắn chưa đọc cho mỗi conversation
        $unreadCounts = [];
        foreach ($conversations as $conv) {
            $unreadCounts[$conv->id] = Chat::where('sender_id', $conv->id)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();
        }

        return view('chat.index', compact('conversations', 'admins', 'customers', 'unreadCounts'));
    }

    /**
     * Chat với user cụ thể
     */
    public function show($userId)
    {
        $receiver = User::findOrFail($userId);
        $currentUserId = Auth::id();

        $messages = Chat::between($currentUserId, $userId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read
        Chat::where('receiver_id', $currentUserId)
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('chat.show', compact('receiver', 'messages'));
    }

    /**
     * Gửi tin nhắn
     */
    public function send(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $receiver = User::findOrFail($userId);

        $chat = Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'message' => $request->message,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'chat' => $chat->load('sender'),
            ]);
        }

        return back();
    }

    /**
     * Lấy tin nhắn mới (API cho auto-refresh)
     */
    public function getMessages($userId)
    {
        $currentUserId = Auth::id();
        
        $messages = Chat::between($currentUserId, $userId)
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read
        Chat::where('receiver_id', $currentUserId)
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json([
            'messages' => $messages
        ]);
    }
}
