@extends('layouts.admin')
@section('orderssection')
<div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">overview</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{$all_registred_users}}</h2>
                                                <span>Registerd users</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart1"></canvas>
                                            <script>
                                           var users1 = <?php echo json_encode($array_number_of_users); ?>;
                                           var months1 = <?php echo json_encode($array_months_users); ?>;
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-collection-item"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{$all_products}}</h2>
                                                <span>All products</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart2"></canvas>
                                            <script>
                                           var products2 = <?php echo json_encode($array_number_of_products); ?>;
                                           var months2 = <?php echo json_encode($array_months_products); ?>;
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-shopping-cart"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{$all_orders}}</h2>
                                                <span>All orders placed</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart3"></canvas>
                                            <script>
                                           var orders3 = <?php echo json_encode($array_number_of_orders); ?>;
                                           var months3 = <?php echo json_encode($array_months_orders); ?>;
                                            </script>
                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{$total_earnings}}</h2>
                                                <span>Total earnings</span>

                                              
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart4"></canvas>
                                            
                                            <script>
                                           var totals4 = <?php echo json_encode($array_totals); ?>;
                                           var months4 = <?php echo json_encode($array_months); ?>;
                                            </script>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection