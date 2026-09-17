/* 
========================================================================
   BOOTSTRAP 5 ADMIN TEMPLATE - SPARK ADMIN
   DASHBOARD CORE JAVASCRIPT MODULE
   Developed with premium UI/UX standards

   Template Name: Spark Admin
   Version: 1.0 
   Author: Spark Admin Team 
   Email: hello.sparkadmin@gmail.com
   URL: https://sparkadmin.web.id
========================================================================
*/

document.addEventListener('DOMContentLoaded', function () {
    // -----------------------------------------------------------------
    // 1. Mobile Sidebar Toggle & Backdrop Overlay
    // -----------------------------------------------------------------
    const sidebar = document.querySelector('.sidebar-wrapper');
    const toggleBtn = document.querySelector('.sidebar-toggle-btn');
    
    // Create and append backdrop overlay for mobile sidebar
    let overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show', sidebar.classList.contains('show'));
        });

        // Close sidebar when clicking on backdrop overlay
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }


    // -----------------------------------------------------------------
    // 2. Revenue Chart (Vertical Bar Chart - Income vs Expenses in ₹)
    // -----------------------------------------------------------------
    const revenueChartEl = document.querySelector('#revenue-chart');
    if (revenueChartEl) {
        const dData = window.dashboardData || {};
        const revCategories = dData.revenueCategories && dData.revenueCategories.length > 0 
            ? dData.revenueCategories 
            : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
        const revIncomeData = dData.revenueCredits && dData.revenueCredits.length > 0 
            ? dData.revenueCredits 
            : [0, 0, 0, 0, 0, 0, 0, 0];
        const revExpensesData = dData.revenueDebits && dData.revenueDebits.length > 0 
            ? dData.revenueDebits 
            : [0, 0, 0, 0, 0, 0, 0, 0];

        const revenueChartOptions = {
            series: [
                {
                    name: 'Income',
                    data: revIncomeData
                },
                {
                    name: 'Expenses',
                    data: revExpensesData
                }
            ],
            chart: {
                type: 'bar',
                height: 220,
                stacked: false,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                },
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            colors: ['#072F1F', '#B4F105'], // Dark Green (Income), Lime Green (Expenses)
            states: {
                hover: {
                    filter: {
                        type: 'none'
                    }
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '48%',
                    borderRadius: 3
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            legend: {
                show: false // Custom legends are drawn statically in HTML to match reference layout
            },
            grid: {
                borderColor: '#E9EFEF',
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                }
            },
            xaxis: {
                categories: revCategories,
                labels: {
                    style: {
                        colors: '#6C7E75',
                        fontSize: '11px',
                        fontWeight: 500
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    show: false // Hides absolute numbers to match simplified reference chart style
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "₹ " + Number(val).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    }
                },
                theme: 'dark'
            }
        };

        const revenueChart = new ApexCharts(revenueChartEl, revenueChartOptions);
        revenueChart.render();
    }

    // -----------------------------------------------------------------
    // 3. Total View / Platform Performance Chart (Donut Chart)
    // -----------------------------------------------------------------
    const viewsChartEl = document.querySelector('#views-chart');
    if (viewsChartEl) {
        const dData = window.dashboardData || {};
        const donutSeries = dData.donutSeries && dData.donutSeries.length > 0 ? dData.donutSeries : [60, 25, 15];
        const donutLabels = dData.donutLabels && dData.donutLabels.length > 0 ? dData.donutLabels : ['Active Profiles', 'Blue Tick Verified', 'Match Interactions'];
        const donutTotalVal = dData.donutTotal !== undefined ? String(dData.donutTotal) : '0';
        const donutTotalLabel = dData.donutTotalLabel || 'Total Profiles';

        const viewsChartOptions = {
            series: donutSeries,
            chart: {
                type: 'donut',
                height: 250,
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            labels: donutLabels,
            colors: ['#B4F105', '#051C12', '#F97316'], // Lime, Forest Dark, Orange
            states: {
                hover: {
                    filter: {
                        type: 'none'
                    }
                }
            },
            legend: {
                show: false // Custom HTML legend used below the chart
            },
            dataLabels: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '12px',
                                fontWeight: 500,
                                color: '#6C7E75',
                                offsetY: -8
                            },
                            value: {
                                show: true,
                                fontSize: '24px',
                                fontWeight: 800,
                                color: '#0B130F',
                                offsetY: 8,
                                formatter: function (val) {
                                    return val + "%";
                                }
                            },
                            total: {
                                show: true,
                                label: donutTotalLabel,
                                fontSize: '11px',
                                fontWeight: 500,
                                color: '#6C7E75',
                                formatter: function (w) {
                                    return donutTotalVal;
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + "%";
                    }
                },
                theme: 'dark'
            }
        };

        const viewsChart = new ApexCharts(viewsChartEl, viewsChartOptions);
        viewsChart.render();
    }

    // -----------------------------------------------------------------
    // 4. Sparkline Charts (Net Income & Total Return in ₹)
    // -----------------------------------------------------------------
    const dData = window.dashboardData || {};
    const incomeSparkData = dData.incomeSparkline && dData.incomeSparkline.length > 0 
        ? dData.incomeSparkline 
        : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    const returnSparkData = dData.returnSparkline && dData.returnSparkline.length > 0 
        ? dData.returnSparkline 
        : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

    const incomeSparkOptions = {
        series: [{
            name: 'Net Income',
            data: incomeSparkData
        }],
        chart: {
            type: 'area',
            height: 45,
            sparkline: {
                enabled: true
            },
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            opacity: 0.1,
            type: 'solid'
        },
        colors: ['#22C55E'], // Green color matching trend-up
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                formatter: function (val) {
                    return "₹ " + Number(val).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                },
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        }
    };

    const returnSparkOptions = {
        series: [{
            name: 'Total Return',
            data: returnSparkData
        }],
        chart: {
            type: 'area',
            height: 45,
            sparkline: {
                enabled: true
            },
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            opacity: 0.1,
            type: 'solid'
        },
        colors: ['#EF4444'], // Red color matching trend-down
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                formatter: function (val) {
                    return "₹ " + Number(val).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                },
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        }
    };

    const incomeSparkEl = document.querySelector('#income-sparkline');
    if (incomeSparkEl) {
        const incomeSpark = new ApexCharts(incomeSparkEl, incomeSparkOptions);
        incomeSpark.render();
    }

    const returnSparkEl = document.querySelector('#return-sparkline');
    if (returnSparkEl) {
        const returnSpark = new ApexCharts(returnSparkEl, returnSparkOptions);
        returnSpark.render();
    }

    // -----------------------------------------------------------------
    // 5. Flatpickr Date Range Picker Initialization & Real-Time Filter
    // -----------------------------------------------------------------
    const datePickerTrigger = document.querySelector('#date-picker-trigger');
    const selectedRangeText = document.querySelector('#selected-date-range');
    
    if (datePickerTrigger && selectedRangeText) {
        const defaultRange = (dData.dateRange && dData.dateRange.length === 2) 
            ? dData.dateRange 
            : [new Date(Date.now() - 30 * 24 * 60 * 60 * 1000), new Date()];

        flatpickr(datePickerTrigger, {
            mode: 'range',
            dateFormat: 'Y-m-d',
            defaultDate: defaultRange,
            onValueUpdate: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const startStr = instance.formatDate(selectedDates[0], 'M j, Y');
                    const endStr = instance.formatDate(selectedDates[1], 'M j, Y');
                    selectedRangeText.textContent = `${startStr} - ${endStr}`;
                } else if (selectedDates.length === 1) {
                    const startStr = instance.formatDate(selectedDates[0], 'M j, Y');
                    selectedRangeText.textContent = startStr;
                }
            },
            onClose: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const startVal = instance.formatDate(selectedDates[0], 'Y-m-d');
                    const endVal = instance.formatDate(selectedDates[1], 'Y-m-d');
                    
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.get('start_date') !== startVal || urlParams.get('end_date') !== endVal) {
                        urlParams.set('start_date', startVal);
                        urlParams.set('end_date', endVal);
                        window.location.href = window.location.pathname + '?' + urlParams.toString();
                    }
                } else if (selectedDates.length === 1) {
                    const startVal = instance.formatDate(selectedDates[0], 'Y-m-d');
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.get('start_date') !== startVal || urlParams.get('end_date') !== startVal) {
                        urlParams.set('start_date', startVal);
                        urlParams.set('end_date', startVal);
                        window.location.href = window.location.pathname + '?' + urlParams.toString();
                    }
                }
            }
        });
    }

    // -----------------------------------------------------------------
    // 6. Desktop Sidebar Minimize Interaction
    // -----------------------------------------------------------------
    const desktopToggleBtn = document.querySelector('#desktop-sidebar-toggle');
    if (desktopToggleBtn) {
        desktopToggleBtn.addEventListener('click', function () {
            document.body.classList.toggle('sidebar-minimized');
            
            // Toggle icon direction
            const icon = desktopToggleBtn.querySelector('i');
            if (icon) {
                if (document.body.classList.contains('sidebar-minimized')) {
                    icon.className = 'bi bi-chevron-bar-right';
                } else {
                    icon.className = 'bi bi-chevron-bar-left';
                }
            }
            
            // Trigger a window resize event so that charts (ApexCharts) redraw correctly
            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 300);
        });
    }

    // -----------------------------------------------------------------
    // 7. Fullscreen Toggle Interaction
    // -----------------------------------------------------------------
    const fullscreenBtn = document.querySelector('#btn-fullscreen');
    if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', function () {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().then(() => {
                    updateFullscreenIcon(true);
                }).catch(err => {
                    console.error(`Error attempting to enable fullscreen mode: ${err.message}`);
                });
            } else {
                document.exitFullscreen().then(() => {
                    updateFullscreenIcon(false);
                }).catch(err => {
                    console.error(`Error attempting to exit fullscreen mode: ${err.message}`);
                });
            }
        });

        function updateFullscreenIcon(isFullscreen) {
            const icon = fullscreenBtn.querySelector('i');
            if (icon) {
                if (isFullscreen) {
                    icon.className = 'bi bi-fullscreen-exit';
                } else {
                    icon.className = 'bi bi-arrows-fullscreen';
                }
            }
        }

        // Listen for browser native fullscreen changes (e.g. Esc key)
        document.addEventListener('fullscreenchange', () => {
            if (document.fullscreenElement) {
                updateFullscreenIcon(true);
            } else {
                updateFullscreenIcon(false);
            }
        });
    }
});
