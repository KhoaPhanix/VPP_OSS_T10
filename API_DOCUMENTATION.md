# API Documentation

## Authentication

All API requests require authentication using Bearer token.

```
Authorization: Bearer {your-token}
```

## Endpoints

### Products

#### GET /api/products
Get list of products

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Product Name",
      "price": 10000,
      "stock": 100
    }
  ]
}
```

#### GET /api/products/{id}
Get product details

### Orders

#### POST /api/orders
Create new order

**Request Body:**
```json
{
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    }
  ]
}
```

## Rate Limiting

- 60 requests per minute for authenticated users
- 20 requests per minute for guests
