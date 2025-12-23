# Workflow - Hệ thống Bán Văn phòng phẩm Online

## 1. Workflow Quy trình Đặt hàng (Order Flow)

```mermaid
flowchart TD
    Start([Khách hàng đăng nhập]) --> Browse[Duyệt sản phẩm]
    Browse --> AddCart[Thêm sản phẩm vào giỏ hàng]
    AddCart --> EditCart{Chỉnh sửa giỏ hàng?}
    EditCart -->|Có| UpdateQty[Cập nhật số lượng/Xóa sản phẩm]
    UpdateQty --> AddCart
    EditCart -->|Không| SubmitOrder[Gửi đơn hàng]
    
    SubmitOrder --> OrderLocked[Đơn hàng: Trạng thái 'Chờ duyệt']
    OrderLocked -.->|KHÔNG được phép| NoEdit[❌ Hủy/Sửa đơn]
    
    OrderLocked --> AdminReview{Admin duyệt đơn}
    AdminReview -->|Duyệt| Approved[✅ Đơn hàng được duyệt]
    AdminReview -->|Từ chối| RejectReason[Nhập lý do từ chối]
    RejectReason --> Rejected[❌ Đơn hàng bị từ chối]
    
    Approved --> UpdateStock[Trừ số lượng tồn kho]
    UpdateStock --> Delivery[Giao hàng cho khách]
    Delivery --> Complete([Hoàn tất đơn hàng])
    
    Rejected --> NotifyCustomer[Thông báo lý do cho khách]
    NotifyCustomer --> End([Kết thúc])
    
    style OrderLocked fill:#ffeb3b
    style Approved fill:#4caf50,color:#fff
    style Rejected fill:#f44336,color:#fff
    style NoEdit fill:#f44336,color:#fff
```

### Quy tắc quan trọng:
- ⚠️ **Sau khi gửi đơn:** Khách hàng KHÔNG được hủy/sửa để tránh xung đột dữ liệu
- ⚠️ **Sau khi duyệt:** Khách hàng KHÔNG được hủy/trả hàng (trừ trường hợp hàng lỗi)
- ⚠️ **Từ chối đơn:** Admin BẮT BUỘC nhập lý do cụ thể

---

## 2. Workflow Quản lý Sản phẩm & Kho

```mermaid
flowchart TD
    Start([Admin đăng nhập]) --> Dashboard[Dashboard quản trị]
    
    Dashboard --> ProductMgmt{Quản lý sản phẩm}
    
    ProductMgmt -->|Thêm mới| AddProduct[Nhập thông tin sản phẩm]
    AddProduct --> ProductInfo[Mã SP, Tên, Mô tả, Đơn vị<br/>Hình ảnh, Giá, Số lượng<br/>Nhà cung cấp, Loại sản phẩm]
    ProductInfo --> ValidateProduct{Kiểm tra dữ liệu}
    ValidateProduct -->|Hợp lệ| SaveProduct[Lưu sản phẩm vào DB]
    ValidateProduct -->|Lỗi| ErrorMsg[Hiển thị lỗi]
    ErrorMsg --> AddProduct
    
    ProductMgmt -->|Cập nhật tồn kho| UpdateStock[Chọn sản phẩm cần cập nhật]
    UpdateStock --> EnterQty[Nhập số lượng nhập kho]
    EnterQty --> AddToStock[Cộng vào số lượng hiện tại]
    AddToStock --> LogStock[Ghi log nhập kho]
    
    ProductMgmt -->|Quản lý danh mục| CategoryMgmt[Thêm/Sửa loại sản phẩm]
    CategoryMgmt --> CategoryList[Bút viết, Giấy tờ, Sổ tay<br/>Dụng cụ học tập<br/>Thiết bị văn phòng...]
    
    SaveProduct --> Success([Thành công])
    LogStock --> Success
    CategoryList --> Success
    
    style SaveProduct fill:#4caf50,color:#fff
    style ErrorMsg fill:#f44336,color:#fff
```

---

## 3. Workflow Quản lý Thành viên

```mermaid
flowchart TD
    Start([Người dùng truy cập]) --> Register{Đăng ký thành viên}
    
    Register --> InputInfo[Nhập thông tin đăng ký]
    InputInfo --> MemberInfo[Username, Password<br/>Họ tên, Giới tính, Ngày sinh<br/>Địa chỉ, SĐT, Hình đại diện]
    
    MemberInfo --> Validate{Kiểm tra hợp lệ}
    Validate -->|Username trùng| ErrorDup[Lỗi: Tài khoản đã tồn tại]
    ErrorDup --> InputInfo
    Validate -->|Thiếu thông tin| ErrorMissing[Lỗi: Vui lòng điền đầy đủ]
    ErrorMissing --> InputInfo
    
    Validate -->|Hợp lệ| CreateAccount[Tạo tài khoản thành viên]
    CreateAccount --> VerifyEmail[Xác nhận email/SĐT]
    VerifyEmail --> Active[Kích hoạt tài khoản]
    
    Active --> Login[Đăng nhập hệ thống]
    Login --> AccessFeatures[Truy cập tính năng:<br/>- Mua hàng<br/>- Xem lịch sử đơn<br/>- Chat hỗ trợ]
    
    AccessFeatures --> End([Hoàn tất])
    
    style CreateAccount fill:#4caf50,color:#fff
    style ErrorDup fill:#f44336,color:#fff
    style ErrorMissing fill:#f44336,color:#fff
```

---

## 4. Workflow Hệ thống Chat

```mermaid
flowchart TD
    Start([Thành viên đăng nhập]) --> ChatDashboard[Mở tính năng Chat]
    
    ChatDashboard --> SelectType{Chọn loại chat}
    
    SelectType -->|Chat với Admin| AdminChat[Kết nối với Admin]
    AdminChat --> AdminSupport[Tư vấn sản phẩm<br/>Hỗ trợ kỹ thuật<br/>Giải đáp thắc mắc]
    
    SelectType -->|Chat với thành viên| MemberChat[Tìm kiếm thành viên]
    MemberChat --> P2PChat[Chat trực tiếp 1-1]
    
    AdminSupport --> SendMsg[Gửi/Nhận tin nhắn real-time]
    P2PChat --> SendMsg
    
    SendMsg --> SaveHistory[Lưu lịch sử chat]
    SaveHistory --> Notification[Thông báo tin nhắn mới]
    
    Notification --> End([Kết thúc phiên chat])
    
    style SendMsg fill:#2196f3,color:#fff
```

---

## 5. Workflow Thống kê & Báo cáo (Admin)

```mermaid
flowchart TD
    Start([Admin đăng nhập]) --> ReportDashboard[Dashboard báo cáo]
    
    ReportDashboard --> SelectReport{Chọn loại báo cáo}
    
    SelectReport -->|Doanh thu| Revenue[Báo cáo doanh thu]
    Revenue --> SelectPeriod{Chọn kỳ báo cáo}
    SelectPeriod -->|Tuần| WeeklyReport[Doanh thu theo tuần]
    SelectPeriod -->|Tháng| MonthlyReport[Doanh thu theo tháng]
    SelectPeriod -->|Quý| QuarterReport[Doanh thu theo quý]
    
    SelectReport -->|Hành vi mua hàng| BehaviorAnalysis[Phân tích hành vi]
    BehaviorAnalysis --> PeakHours[Thời gian cao điểm theo giờ]
    
    SelectReport -->|Sản phẩm bán chạy| TopProducts[Top 5 sản phẩm bán chạy]
    TopProducts --> WeeklyTop[Thống kê trong tuần]
    
    WeeklyReport --> GenerateChart[Tạo biểu đồ/Bảng số liệu]
    MonthlyReport --> GenerateChart
    QuarterReport --> GenerateChart
    PeakHours --> GenerateChart
    WeeklyTop --> GenerateChart
    
    GenerateChart --> ExportReport[Xuất báo cáo PDF/Excel]
    ExportReport --> End([Hoàn tất])
    
    style GenerateChart fill:#ff9800,color:#fff
    style ExportReport fill:#4caf50,color:#fff
```

---

## 6. Workflow Tổng quan Hệ thống

```mermaid
flowchart TB
    subgraph Customer["👤 Khách hàng (Thành viên)"]
        C1[Đăng ký/Đăng nhập]
        C2[Duyệt sản phẩm]
        C3[Quản lý giỏ hàng]
        C4[Gửi đơn hàng]
        C5[Chat hỗ trợ]
        C6[Xem lịch sử]
    end
    
    subgraph System["⚙️ Hệ thống xử lý"]
        S1[(Database)]
        S2[API Backend]
        S3[Authentication]
        S4[Payment Gateway]
        S5[Notification Service]
        S6[Chat Service]
    end
    
    subgraph Admin["👨‍💼 Quản trị viên"]
        A1[Quản lý sản phẩm]
        A2[Quản lý danh mục]
        A3[Duyệt đơn hàng]
        A4[Cập nhật kho]
        A5[Xem báo cáo]
        A6[Chat support]
    end
    
    C1 --> S3
    C2 --> S2
    C3 --> S2
    C4 --> S2
    C5 --> S6
    C6 --> S2
    
    S2 --> S1
    S3 --> S1
    S4 --> S1
    S5 --> S1
    S6 --> S1
    
    A1 --> S2
    A2 --> S2
    A3 --> S2
    A4 --> S2
    A5 --> S2
    A6 --> S6
    
    S2 --> S5
    S5 -.->|Thông báo| C6
    S5 -.->|Thông báo| A3
    
    style Customer fill:#e3f2fd
    style Admin fill:#fff3e0
    style System fill:#f3e5f5
```

---

## 7. Ma trận Phân quyền

| Tính năng | Khách hàng | Thành viên | Admin |
|-----------|:----------:|:----------:|:-----:|
| Xem sản phẩm | ✅ | ✅ | ✅ |
| Thêm giỏ hàng | ❌ | ✅ | ✅ |
| Đặt hàng | ❌ | ✅ | ✅ |
| Hủy đơn (Chờ duyệt) | ❌ | ❌ | ✅ |
| Hủy đơn (Đã duyệt) | ❌ | ❌ | ❌ |
| Duyệt đơn | ❌ | ❌ | ✅ |
| Thêm/Sửa sản phẩm | ❌ | ❌ | ✅ |
| Cập nhật kho | ❌ | ❌ | ✅ |
| Xem báo cáo | ❌ | ❌ | ✅ |
| Chat | ❌ | ✅ | ✅ |
| Đăng ký thành viên | ✅ | - | - |

---

## 8. Trạng thái Đơn hàng

```mermaid
stateDiagram-v2
    [*] --> GioHang: Thêm sản phẩm
    GioHang --> ChoDuyet: Gửi đơn hàng
    
    ChoDuyet --> DaDuyet: Admin duyệt
    ChoDuyet --> TuChoi: Admin từ chối
    
    DaDuyet --> DangGiao: Bắt đầu giao hàng
    DangGiao --> HoanTat: Giao thành công
    
    TuChoi --> [*]: Thông báo khách hàng
    HoanTat --> [*]: Hoàn tất
    
    note right of ChoDuyet
        Không được phép hủy/sửa
    end note
    
    note right of DaDuyet
        Không được phép hủy
        (trừ hàng lỗi)
    end note
```

---

## 9. Use Cases chính

### UC-01: Đặt hàng
**Actor:** Thành viên  
**Mô tả:** Thành viên chọn sản phẩm, thêm vào giỏ hàng và gửi đơn hàng

### UC-02: Duyệt đơn hàng
**Actor:** Admin  
**Mô tả:** Admin xem xét và duyệt/từ chối đơn hàng của khách

### UC-03: Quản lý sản phẩm
**Actor:** Admin  
**Mô tả:** Admin thêm mới sản phẩm và cập nhật thông tin kho

### UC-04: Chat hỗ trợ
**Actor:** Thành viên, Admin  
**Mô tả:** Trao đổi trực tuyến giữa thành viên hoặc với Admin

### UC-05: Xem báo cáo doanh thu
**Actor:** Admin  
**Mô tả:** Theo dõi doanh thu theo tuần/tháng/quý và sản phẩm bán chạy

---

## 📌 Lưu ý triển khai

### Bảo mật
- Mã hóa mật khẩu thành viên (bcrypt/SHA256)
- JWT/Session cho authentication
- HTTPS cho mọi giao tiếp

### Hiệu năng
- Cache danh sách sản phẩm hot
- Index database cho tìm kiếm nhanh
- Lazy loading hình ảnh sản phẩm

### Quy tắc nghiệp vụ
- ✅ Kiểm tra tồn kho trước khi cho phép đặt hàng
- ✅ Lock đơn hàng ngay sau khi gửi (trạng thái "Chờ duyệt")
- ✅ Transaction khi trừ kho để đảm bảo nhất quán dữ liệu
- ✅ Bắt buộc lý do khi Admin từ chối đơn

---

**Phiên bản:** 1.0  
**Cập nhật:** 16/12/2025  
**Nhóm phát triển:** VPP_OSS_T10
