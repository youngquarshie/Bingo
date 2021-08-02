

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <?php if($is_admin == true || $is_admin2 == true): ?>

        <div class="row">

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
              
              <h3>¢<?php echo number_format(($total_balance[0]["SUM(actual_total_balance)"])); ?></h3>

                <p>Total Balance</p>
              </div>
              <div class="icon">
              <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="<?php echo base_url('notifications/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
          </div>


          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
              <h3>¢<?php echo number_format(($total_wins[0]["SUM(total_wins)"])); ?></h3>

                <p>Total Wins</p>
              </div>
              <div class="icon">
              <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="<?php echo base_url('products/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
              <h3>¢<?php echo number_format(($total_gross[0]["SUM(gross_amount)"])); ?></h3>

                <p>Total Gross </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="<?php echo base_url('records/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
              <h3>¢<?php echo number_format(($total_net[0]["SUM(net_amount)"])); ?></h3>

                <p>Total Net</p>
              </div>
              <div class="icon">
              <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="<?php echo base_url('users/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
         
        </div>
        <!-- /.row -->
      <?php endif; ?>



      <!-- if not admin -->
      
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
      $("#dashboardMainMenu").addClass('active');
    }); 
  </script>
