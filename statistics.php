<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ระบบตรวจจับขยะที่เป็นไปได้</title>
        <link rel="stylesheet" href="index4.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

    <body>
        <div class="navbar">
        <div class="bar-logo">
        <a href="index.php">
        <div class="logo-image" style="background-image: url('litter7.png');"></div>
    </a>
        </div>
            <ul class="bar-all">
            <li><a href="cctv.php">CCTV</a></li>
            <li><a href="detection.php">Detection</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                
                <li><a href="statistics.php">Statistics</a></li>
                
            </ul>
            
            <div class="bar-btn">
            <button type="button" class="logout-link" onclick="window.location.href='login.php';">Login</button>
            </div>
        </div>
        <div class="button-container">
            <button onclick="fetchAndCreateChart('today')">DAY</button>
            <button onclick="fetchAndCreateChart('weekly')">WEEK</button>
            <button onclick="fetchAndCreateChart('month')">MONTH</button>
            <div class="select-container">
                <select id="yearSelector" onchange="fetchAndCreateChart('yearly', this.value)">
                
                <option value="2024" selected>YEAR 2024</option>
        <option value="2023">YEAR 2023</option>
        
        <!-- เพิ่ม option เพิ่มเติมตามความต้องการ -->
    </select>   
</div>
        </div>
        
        <div class="chart-wrapper">

    <div class="chart-container" style="width: 30%; height: 150%;">
        <canvas id="todayChart" width="150" height="150"></canvas>

        <!-- แสดงกราฟปริมาณขยะรายสัปดาห์ -->
        <canvas id="weeklyChart" width="150" height="150"></canvas>

        <!-- แสดงกราฟปริมาณขยะรายเดือน -->
        <canvas id="monthlyChart" width="150" height="150"></canvas>

        <!-- แสดงกราฟปริมาณขยะรายปี -->
        <canvas id="yearlyChart" width="150" height="150"></canvas>
    </div>

    <!-- ปุ่มเปลี่ยนแสดงกราฟต่าง ๆ -->
</div>


        <script>
            
                // ฟังก์ชันในการดึงข้อมูลและสร้างกราฟตามประเภท
                function fetchAndCreateChart(type, selectedYear) {
    // ซ่อนทุกกราฟ
    hideAllCharts();

    switch (type) {
        case 'today':
            fetchTodayData(createTodayChart);
            break;
        case 'weekly':
            fetchWeeklyData(createWeeklyChart);
            break;
        case 'yearly':
            
            fetchMonthlyData(selectedYear, createMonthlyChart);
            break;
        case 'month':
            fetchYearlyData(createYearlyChart);
            break;
        default:
            console.error('ประเภทที่ไม่ถูกต้อง');
            break;
    }
}


    // เพิ่มฟังก์ชันเพื่อทำลาย Chart เก่า
    function hideAllCharts() {
        if (todayChart) {
            todayChart.destroy();
        }
        if (weeklyChart) {
            weeklyChart.destroy();
        }
        if (monthlyChart) {
            monthlyChart.destroy();
        }
        if (yearlyChart) {
            yearlyChart.destroy();
        }
    }

                // ฟังก์ชันดึงข้อมูลขยะประจำวัน
                function fetchTodayData(callback) {
                    fetch('severstatic.php?type=today')
                        .then(response => response.json())
                        .then(data => {
                            // แสดงกราฟประจำวัน
                            document.getElementById('todayChart').style.display = 'block';
                            callback(data);
                        });
                }

                function fetchWeeklyData(callback) {
    fetch('severstatic.php?type=weekly')
        .then(response => response.json())
        .then(data => {
            // แสดงกราฟสัปดาห์
            document.getElementById('weeklyChart').style.display = 'block';
            callback(data);
        })
        .catch(error => console.error('เกิดข้อผิดพลาดในการดึงข้อมูลรายสัปดาห์:', error));
}   

                // ฟังก์ชันดึงข้อมูลขยะประจำเดือน
                function fetchMonthlyData(year, callback) {
                    fetch(`severstatic.php?type=monthly&year=${year}`)
                        .then(response => response.json())
                        .then(data => {
                            // แสดงกราฟรายเดือน
                            document.getElementById('monthlyChart').style.display = 'block';
                            callback(data);
                        });
                }

                function fetchYearlyData(callback) {
                    fetch('severstatic.php?type=month')
                        .then(response => response.json())
                        .then(data => {
                            
                            document.getElementById('yearlyChart').style.display = 'block';
                            callback(data);
                        });
                }
              
                // ฟังก์ชันสร้างกราฟประจำวัน
                function createTodayChart(data) {
                    var ctx = document.getElementById('todayChart').getContext('2d');
                    var labels = data.map(entry => entry.hour_range);
                    var quantities = data.map(entry => entry.total_quantity);

                    todayChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            
                            labels: labels,
                            datasets: [{
                                label: 'ปริมาณขยะวันนี้',
                                data: quantities,
                                
                                backgroundColor: 'rgba(0, 255, 238,0.827)',
                borderColor: 'rgba(0, 255, 238)',
                borderWidth: 3, // ปรับขนาดของเส้นเส้น
                
                            }]
                        },
                        options: {
                            scales: {
    x: {
        ticks: {
            color: 'white', // เปลี่ยนสีของตัวเลขแกน x เป็นสีขาว
        }
    },
    y: {
        beginAtZero: true,
        ticks: {
            color: 'white' // เปลี่ยนสีของตัวเลขแกน y เป็นสีขาว
            
        }
    }
},
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff', // เปลี่ยนสีของข้อความในตำแหน่งคำอธิบายเป็นสีขาว
                        font: {
                            color: '#ffffff', // เปลี่ยนสีของตัวหนังสือในตำแหน่งคำอธิบายเป็นสีขาว
                            size: 18, // ปรับขนาดของตัวหนังสือในตำแหน่งคำอธิบาย
                            
                            }
                        
                    }
                }
                            }
                        }
                    });
                }

                // ฟังก์ชันสร้างกราฟประจำสัปดาห์
                function createWeeklyChart(data) {
    var ctx = document.getElementById('weeklyChart').getContext('2d');
    
    // Extracting labels and quantities from data
    var labels = data.map(entry => entry.week_range);
    var quantities = data.map(entry => entry.total);

    // Creating the bar chart
     weeklyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'ปริมาณขยะรายสัปดาห์',
                    
                
                data: quantities,
                backgroundColor: 'rgba(0, 255, 238,0.827)',
                borderColor: 'rgba(0, 255, 238)',
                borderWidth: 3, // ปรับขนาดของเส้นเส้น
                
            }]
        },
        options: {
            scales: {
    x: {
        ticks: {
            color: 'white', // เปลี่ยนสีของตัวเลขแกน x เป็นสีขาว
        }
    },
    y: {
        beginAtZero: true,
        ticks: {
            color: 'white' // เปลี่ยนสีของตัวเลขแกน y เป็นสีขาว
        }
    }
},
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff', // เปลี่ยนสีของข้อความในตำแหน่งคำอธิบายเป็นสีขาว
                        font: {
                            color: '#ffffff', // เปลี่ยนสีของตัวหนังสือในตำแหน่งคำอธิบายเป็นสีขาว
                            size: 18 // ปรับขนาดของตัวหนังสือในตำแหน่งคำอธิบาย
                        }
                        
                    }
                }
            }
        }
    });
}

                // ฟังก์ชันสร้างกราฟประจำเดือน
                function createMonthlyChart(data) {
                    var ctx = document.getElementById('monthlyChart').getContext('2d');
                    var labels = data.map(entry => entry.month);
                    var quantities = data.map(entry => entry.total);

                    monthlyChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'ปริมาณขยะรายปี',
                                data: quantities,
                                backgroundColor: 'rgba(0, 255, 238,0.827)',
                borderColor: 'rgba(0, 255, 238)',
                borderWidth: 3, // ปรับขนาดของเส้นเส้น
              
                            }]
                        },
                        options: {
                            scales: {
    x: {
        ticks: {
            color: 'white', // เปลี่ยนสีของตัวเลขแกน x เป็นสีขาว
        }
    },
    y: {
        beginAtZero: true,
        ticks: {
            color: 'white' // เปลี่ยนสีของตัวเลขแกน y เป็นสีขาว
        }
    }
},
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff', // เปลี่ยนสีของข้อความในตำแหน่งคำอธิบายเป็นสีขาว
                        font: {
                            color: '#ffffff', // เปลี่ยนสีของตัวหนังสือในตำแหน่งคำอธิบายเป็นสีขาว
                            size: 18 // ปรับขนาดของตัวหนังสือในตำแหน่งคำอธิบาย
                        }
                    }
                }
                            }
                        }
                    });
                }

                // ฟังก์ชันสร้างกราฟประจำปี
                function createYearlyChart(data) {
                    var ctx = document.getElementById('yearlyChart').getContext('2d');
                    var labels = data.map(entry => entry.date);
                    var quantities = data.map(entry => entry.total);

                    yearlyChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'ปริมาณขยะรายเดือน',
                                data: quantities,
                                backgroundColor: 'rgba(0, 255, 238,0.827)',
                borderColor: 'rgba(0, 255, 238)',
                borderWidth: 3 , // ปรับขนาดของเส้นเส้น
               
                            }]
                        },
                        options: {
                            scales: {
    x: {
        ticks: {
            color: 'white', // เปลี่ยนสีของตัวเลขแกน x เป็นสีขาว
        }
    },
    y: {
        beginAtZero: true,
        ticks: {
            color: 'white' // เปลี่ยนสีของตัวเลขแกน y เป็นสีขาว
        }
    }
},
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff', // เปลี่ยนสีของข้อความในตำแหน่งคำอธิบายเป็นสีขาว
                        font: {
                            color: '#ffffff', // เปลี่ยนสีของตัวหนังสือในตำแหน่งคำอธิบายเป็นสีขาว
                            size: 18 // ปรับขนาดของตัวหนังสือในตำแหน่งคำอธิบาย
                        }
                    }
                }
                            }
                        }
                    });
                }
                var todayChart, weeklyChart, monthlyChart, yearlyChart;
                document.addEventListener("DOMContentLoaded", function () {
                // กำหนดให้โค้ดทำงานเมื่อหน้าเว็บโหลดเสร็จ
                fetchAndCreateChart('today');
                document.getElementById('yearSelector').value = new Date().getFullYear();
            });
            
        </script>
    </body>

    </html>