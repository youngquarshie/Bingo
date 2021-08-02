

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Weekly Sales 
      <small>Reports</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Weekly Sales</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
    
    <div class="col-md-12 col-xs-12">
          <form class="form-inline" action="<?php //echo base_url('reports/daily_reports') ?>" method="POST">
            <div class="form-group">
              <label for="date">Select Date</label>
              
              <input type="date" name="daily_date" id="daily_date">
            </div>
          </form>
    </div>

        <br /> <br />

      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title" id="data">Weekly Records Reports</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="daily-sales" class="table table-bordered table-striped display">
            <thead>
              <tr>
                <th></th>
                <th>Total Wins</th>
                <th>Gross Amount</th>
                <th>Net Amount</th>
                <th>Total Balance</th>
                <th>Date Added</th>
              </tr>
              </thead>

              <tfoot align="right">
		          <tr>
              <th>Overall Total</th>
              <th >¢ <span id="total_wins"></span></th>
              <th >¢ <span id="total_gross"></span></th>
              <th >¢ <span id="total_net"></span></th>
              <th >¢ <span id="total_balance"></span></th>
              <th ></th>
              </tr>
	            </tfoot>
          
   
            </table>
           
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->


  
</div>
<!-- /.content-wrapper -->





<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {



  $("#reportNav").addClass('active');
  $("#weeklyreportNav").addClass('active');

  $.fn.digits = function(){ 
    return this.each(function(){ 
        $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
    })
}


  // initialize the datatable 
  manageTable = $('#daily-sales').DataTable({
    ajax: {
        url: base_url + 'reports/weeklyData/',
        type: 'get',
        },
        
    // 'ajax': base_url + 'reports/fetchOrderData/'+selected_date,
    drawCallback: function () {
      var api = this.api();
      $( "#total_wins" ).html(
        this.fnSettings().fnFormatNumber(api.column( 1, {page:'current'} ).data().sum())
      )
      $( "#total_gross" ).html(
        this.fnSettings().fnFormatNumber(api.column( 2, {page:'current'} ).data().sum())
      );
      $( "#total_net" ).html(
        this.fnSettings().fnFormatNumber(api.column( 3, {page:'current'} ).data().sum())
      );
      $( "#total_balance" ).html(
        this.fnSettings().fnFormatNumber(api.column( 4, {page:'current'} ).data().sum())
      );
    },
    
    
     responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'excel', title: 'Daily Sales Report'},
                    {extend: 'pdf', title: 'Daily Sales Report'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

        
        
  });



});

</script>


 
