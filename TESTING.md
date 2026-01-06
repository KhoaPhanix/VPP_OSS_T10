# Testing Guide

## Running Tests

### PHPUnit Tests

```bash
php artisan test
```

### Specific Test Suite

```bash
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

### Coverage Report

```bash
php artisan test --coverage
```

## Writing Tests

### Feature Test Example

```php
public function test_user_can_add_product_to_cart()
{
    $user = User::factory()->create();
    $product = Product::factory()->create();
    
    $response = $this->actingAs($user)
        ->post("/cart/add/{$product->id}");
    
    $response->assertStatus(302);
    $this->assertDatabaseHas('carts', [
        'user_id' => $user->id,
        'product_id' => $product->id
    ]);
}
```

## Test Database

Tests use SQLite in-memory database by default.
