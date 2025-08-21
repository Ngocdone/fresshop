<?php
require_once "../frontend/model/database.php";
require_once ("model/StatisticsModel.php");

class StatisticsController {
    private $statisticsModel;

    public function __construct() {
        $this->statisticsModel = new StatisticsModel();
    }

    public function index() {
        try {
            error_log("Starting statistics data collection...");
            
            $dailyStats = $this->statisticsModel->getDailyRevenue();
            error_log("Daily Stats: " . print_r($dailyStats, true));
            
            $weeklyStats = $this->statisticsModel->getWeeklyRevenue();
            error_log("Weekly Stats: " . print_r($weeklyStats, true));
            
            $monthlyStats = $this->statisticsModel->getMonthlyRevenue();
            error_log("Monthly Stats: " . print_r($monthlyStats, true));
            
            $products = $this->statisticsModel->getTopSellingProducts();
            error_log("Products data: " . print_r($products, true));
            
            $customers = $this->statisticsModel->getTopCustomers();
            error_log("Customers data: " . print_r($customers, true));
            
            $stats = $this->statisticsModel->getTotalStats();
            error_log("Stats data: " . print_r($stats, true));

            // Prepare data for view
            $data = [
                'dailyStats' => $dailyStats,
                'weeklyStats' => $weeklyStats,
                'monthlyStats' => $monthlyStats,
                'topProducts' => $products,
                'customers' => $customers,
                'totalCustomers' => count($customers),
                'stats' => $stats
            ];
            
            // Debug top products data
            error_log("Top Products Data: " . print_r($products, true));
            
            return $data;
        } catch (Exception $e) {
            error_log("Statistics Error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }
}
?>
