<?php

namespace Database\Seeders;

use App\Models\CategorySparePart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySparePartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorySpareParts = [
            // Komponen Utama
            ['name' => 'CPU (Processor)', 'description' => '-'],
            ['name' => 'Motherboard', 'description' => '-'],
            ['name' => 'RAM (Memory)', 'description' => '-'],
            ['name' => 'GPU (Graphics Card)', 'description' => '-'],
            ['name' => 'PSU (Power Supply Unit)', 'description' => '-'],
            ['name' => 'SSD (Solid State Drive)', 'description' => '-'],
            ['name' => 'HDD (Hard Disk Drive)', 'description' => '-'],

            // Penyimpanan Data
            ['name' => 'External HDD', 'description' => '-'],
            ['name' => 'External SSD', 'description' => '-'],
            ['name' => 'USB Flash Drive', 'description' => '-'],
            ['name' => 'Memory Card (SD, microSD)', 'description' => '-'],

            // Pendingin
            ['name' => 'CPU Cooler (Air Cooler, Liquid Cooler)', 'description' => '-'],
            ['name' => 'Case Fan', 'description' => '-'],
            ['name' => 'Thermal Paste', 'description' => '-'],

            // Casing
            ['name' => 'PC Case (Tower, Mini-Tower, Mid-Tower, Full-Tower)', 'description' => '-'],
            ['name' => 'Laptop Housing/Chassis', 'description' => '-'],

            // Input/Output Devices
            ['name' => 'Keyboard', 'description' => '-'],
            ['name' => 'Mouse', 'description' => '-'],
            ['name' => 'Touchpad', 'description' => '-'],
            ['name' => 'Trackpad', 'description' => '-'],
            ['name' => 'Laptop Keyboard Replacement', 'description' => '-'],

            // Audio & Video
            ['name' => 'Sound Card', 'description' => '-'],
            ['name' => 'Speakers', 'description' => '-'],
            ['name' => 'Headphones', 'description' => '-'],
            ['name' => 'Microphone', 'description' => '-'],
            ['name' => 'Webcam', 'description' => '-'],

            // Display
            ['name' => 'Monitor', 'description' => '-'],
            ['name' => 'Laptop Screen Replacement', 'description' => '-'],

            // Connectivity
            ['name' => 'Network Card (Ethernet, Wi-Fi)', 'description' => '-'],
            ['name' => 'Bluetooth Adapter', 'description' => '-'],
            ['name' => 'USB Hub', 'description' => '-'],
            ['name' => 'Docking Station', 'description' => '-'],

            // Optical Drive
            ['name' => 'DVD/CD Drive', 'description' => '-'],
            ['name' => 'Blu-ray Drive', 'description' => '-'],

            // Power & Battery
            ['name' => 'Laptop Battery', 'description' => '-'],
            ['name' => 'Laptop Charger/Adapter', 'description' => '-'],
            ['name' => 'UPS (Uninterruptible Power Supply)', 'description' => '-'],

            // Miscellaneous
            ['name' => 'Expansion Cards (PCIe Cards)', 'description' => '-'],
            ['name' => 'Cables (HDMI, DisplayPort, Ethernet, USB)', 'description' => '-'],
            ['name' => 'Adapters (USB to HDMI, USB to Ethernet)', 'description' => '-'],
            ['name' => 'Screws and Standoffs', 'description' => '-'],
            ['name' => 'Laptop Hinges', 'description' => '-'],

            // Consumables
            ['name' => 'Ink Cartridges', 'description' => '-'],
            ['name' => 'Toner Cartridges', 'description' => '-'],
            ['name' => 'Drum Units', 'description' => '-'],
            ['name' => 'Ribbon Cartridges', 'description' => '-'],

            // Paper Handling
            ['name' => 'Paper Tray', 'description' => '-'],
            ['name' => 'Paper Feeder', 'description' => '-'],
            ['name' => 'Paper Rollers', 'description' => '-'],
            ['name' => 'Duplex Unit', 'description' => '-'],

            // Print Head
            ['name' => 'Print Head Replacement', 'description' => '-'],

            // Fuser Assembly
            ['name' => 'Fuser Unit', 'description' => '-'],
            ['name' => 'Fuser Roller', 'description' => '-'],

            // Transfer Assembly
            ['name' => 'Transfer Belt', 'description' => '-'],
            ['name' => 'Transfer Roller', 'description' => '-'],

            // Maintenance Kits
            ['name' => 'Maintenance Kits (including rollers, fuser, etc.)', 'description' => '-'],

            // Connectivity (Printer)
            ['name' => 'Network Interface Cards', 'description' => '-'],
            ['name' => 'USB Interface Boards', 'description' => '-'],
            ['name' => 'Wi-Fi Modules', 'description' => '-'],

            // Power & Control
            ['name' => 'Power Supply Unit (Printer)', 'description' => '-'],
            ['name' => 'Control Panel', 'description' => '-'],
            ['name' => 'Main Logic Board (Motherboard for printer)', 'description' => '-'],

            // Other Mechanical Parts
            ['name' => 'Gears', 'description' => '-'],
            ['name' => 'Belts', 'description' => '-'],
            ['name' => 'Motors', 'description' => '-'],

            // Covers & Housing
            ['name' => 'Printer Covers', 'description' => '-'],
            ['name' => 'Panels and Doors', 'description' => '-'],

            // Miscellaneous (Printer)
            ['name' => 'Sensors', 'description' => '-'],
            ['name' => 'Cables (Printer)', 'description' => '-'],
            ['name' => 'Cleaning Kits', 'description' => '-'],

            // Spare part untuk LCD Projector
            // Lamp & Light Source
            ['name' => 'Projector Lamp', 'description' => '-'],
            ['name' => 'Lamp Housing', 'description' => '-'],
            ['name' => 'Lamp Ballast', 'description' => '-'],

            // Optical Components
            ['name' => 'Projection Lens', 'description' => '-'],
            ['name' => 'Color Wheel', 'description' => '-'],
            ['name' => 'DMD Chip (Digital Micromirror Device)', 'description' => '-'],
            ['name' => 'LCD Panel', 'description' => '-'],
            ['name' => 'Mirror', 'description' => '-'],
            ['name' => 'Prism Assembly', 'description' => '-'],
            ['name' => 'Optical Engine', 'description' => '-'],

            // Cooling & Airflow
            ['name' => 'Cooling Fan', 'description' => '-'],
            ['name' => 'Filter', 'description' => '-'],

            // Electronics
            ['name' => 'Power Supply Unit', 'description' => '-'],
            ['name' => 'Mainboard', 'description' => '-'],
            ['name' => 'Input/Output Ports (HDMI, VGA, USB, etc.)', 'description' => '-'],

            // Controls & Sensors
            ['name' => 'Remote Control', 'description' => '-'],
            ['name' => 'IR Sensor', 'description' => '-'],
            ['name' => 'Control Buttons', 'description' => '-'],
            ['name' => 'Temperature Sensor', 'description' => '-'],

            // Housing & Mounts
            ['name' => 'Projector Housing', 'description' => '-'],
            ['name' => 'Lens Cap', 'description' => '-'],
            ['name' => 'Projector Mount', 'description' => '-'],

            // Connectivity & Accessories
            ['name' => 'Wireless Module', 'description' => '-'],
            ['name' => 'Speakers (Projector)', 'description' => '-'],
            ['name' => 'Audio Jack', 'description' => '-'],
            ['name' => 'Battery for Remote', 'description' => '-'],
            ['name' => 'Carrying Case', 'description' => '-'],

            // Adjustment Mechanisms
            ['name' => 'Lamp Timer Reset', 'description' => '-'],
            ['name' => 'Adjustment Feet', 'description' => '-'],
            ['name' => 'Lens Shift Mechanism', 'description' => '-'],
            ['name' => 'Zoom Mechanism', 'description' => '-'],
            ['name' => 'Focus Mechanism', 'description' => '-'],

            // Miscellaneous
            ['name' => 'Lamp Cover', 'description' => '-'],
            ['name' => 'Cooling System', 'description' => '-'],
            ['name' => 'Alignment Tools', 'description' => '-'],
            ['name' => 'Dust Cover', 'description' => '-'],
        ];

        foreach ($categorySpareParts as $categorySparePart) {
            CategorySparePart::create($categorySparePart);
        }
    }
}
