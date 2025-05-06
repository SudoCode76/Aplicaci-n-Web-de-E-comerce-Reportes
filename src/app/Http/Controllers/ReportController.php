<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    


    public function testApi()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'La API funciona correctamente 🚀'
        ]);
    }

    // 1. Número total de pedidos enviados con modo de envío 'First Class'
    public function totalOrdersFirstClass()
    {
        $total = Orders::where('ship_mode', 'First Class')->count();  // Consulta para contar los pedidos con 'First Class'
        return response()->json(['total_orders_first_class' => $total]);  // Devolver el resultado en formato JSON
    }

    // 2. Número total de pedidos realizados por el cliente con ID 'DP-13000'
    public function totalOrdersByCustomer($customerId)
    {
        $total = Orders::where('customer_id', $customerId)->count();  // Consulta para contar los pedidos del cliente
        return response()->json(['customer_id' => $customerId, 'total_orders' => $total]);  // Devolver el resultado en formato JSON
    }

    // 3. Producto más rentable por categoría
    public function mostProfitableProductByCategory()
    {
        $results = Orders::select('products.category', 'products.product_name', DB::raw('SUM(orders.profit) as total_profit'))
            ->join('products', 'orders.product_id', '=', 'products.product_id')
            ->groupBy('products.category', 'products.product_name')
            ->orderBy('products.category')
            ->orderByDesc('total_profit')
            ->get()
            ->groupBy('category')
            ->map(function ($group) {
                return $group->first();
            });

        return response()->json($results->values());
    }


    // 4. Clientes con más compras en el último año
    public function topCustomersLastYear()
    {
        $lastYear = now()->subYear()->year;
        $results = Orders::select('customer_id', DB::raw('COUNT(*) as total_orders'))
            ->whereYear('order_date', $lastYear)
            ->groupBy('customer_id')
            ->orderByDesc('total_orders')
            ->take(10)  // Top 10 clientes
            ->get();

        return response()->json($results);
    }

    // 5. Promedio de ventas y ganancias por segmento de clientes
    public function avgSalesAndProfitBySegment()
    {
        $results = Orders::select('segment', DB::raw('AVG(sales) as avg_sales'), DB::raw('AVG(profit) as avg_profit'))
            ->groupBy('segment')
            ->get();

        return response()->json($results);
    }


    // 6. Productos más vendidos por subcategoría
    public function topSellingProductsBySubCategory()
    {
        $results = Orders::select('products.sub_category', 'products.product_name', DB::raw('SUM(orders.quantity) as total_quantity'))
            ->join('products', 'orders.product_id', '=', 'products.product_id')
            ->groupBy('products.sub_category', 'products.product_name')
            ->orderBy('products.sub_category')
            ->orderByDesc('total_quantity')
            ->get()
            ->groupBy('sub_category')
            ->map(function ($group) {
                return $group->first();
            });

        return response()->json($results->values());
    }

    
    // 7. Tendencia de ventas y ganancias por categoría de productos a lo largo del tiempo
    public function salesAndProfitTrendsByCategory()
    {
        $results = Orders::select(
            'products.category',
            DB::raw('YEAR(orders.order_date) as year'),
            DB::raw('SUM(orders.sales) as total_sales'),
            DB::raw('SUM(orders.profit) as total_profit')
        )
            ->join('products', 'orders.product_id', '=', 'products.product_id')
            ->groupBy('products.category', 'year')
            ->orderBy('year')
            ->orderBy('products.category')
            ->get();

        return response()->json($results);
    }

    // 8. Relación entre modo de envío y rentabilidad de los productos
    public function shippingModeProfitability()
    {
        $results = Orders::select('ship_mode', DB::raw('AVG(profit) as avg_profit'))
            ->groupBy('ship_mode')
            ->get();

        return response()->json($results);
    }

    // 9. Clientes que han comprado productos de todas las categorías
    public function customersPurchasedAllCategories()
    {
        $totalCategories = Product::distinct('category')->count('category');

        $results = Orders::select('customer_id')
            ->join('products', 'orders.product_id', '=', 'products.product_id')
            ->groupBy('customer_id')
            ->havingRaw('COUNT(DISTINCT products.category) = ?', [$totalCategories])
            ->get();

        return response()->json($results);
    }


    // 10. Distribución de ventas y ganancias por región y segmento de clientes
    public function salesAndProfitByRegionAndSegment()
    {
        $results = Orders::select(
            'locations.region',
            'orders.segment',
            DB::raw('SUM(orders.sales) as total_sales'),
            DB::raw('SUM(orders.profit) as total_profit')
        )
            ->join('locations', 'orders.postal_code', '=', 'locations.postal_code')
            ->groupBy('locations.region', 'orders.segment')
            ->get();

        return response()->json($results);
    }


    // 11. Clientes con más de 10 pedidos por año (2020-2023)
    public function customersWithMoreThan10OrdersPerYear()
    {
        $results = Orders::select(
            'customer_id',
            DB::raw('YEAR(order_date) as year'),
            DB::raw('COUNT(*) as total_orders')
        )
            ->whereIn(DB::raw('YEAR(order_date)'), [2020, 2021, 2022, 2023])
            ->groupBy('customer_id', 'year')
            ->having('total_orders', '>', 10)
            ->orderBy('year')
            ->orderByDesc('total_orders')
            ->get();

        return response()->json($results);
    }




}
