

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Sales By Game
      <small>Reports</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Sales by Game Report</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">

    <div class="col-md-12 col-xs-12">
          <div class="form-group">
                  <label for="game">Game</label>
                  <select class="form-control select_group" id="game" name="game" >
                  <option selected disabled>Select Game</option>
                    <?php foreach ($game as $k => $v): ?>
                      <option value="<?php echo $v['id'] ?>"><?php echo $v['name_of_game'] ?></option>
                    <?php endforeach ?>
                  </select>
          </div>
            <!-- <button type="submit" class="btn btn-default">Submit</button> -->
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
            <h3 class="box-title" id="data">Sales By Game Reports</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="daily-sales" class="table table-bordered table-striped display">
            <thead>
              <tr>
                <th></th>
                <th>Game</th>
                <th>No of Books</th>
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
              <th></th>
              <th></th>
              <th></th>
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
  $("#GameSalesNav").addClass('active');

  // #myInput is a <input type="text"> element
  $('#game').on( 'change', function () {
    var game_data= $(this).val();
    //alert(category_data);
    $('#daily-sales').DataTable().clear().destroy();

    manageTable = $('#daily-sales').DataTable({
    ajax: {
        url: base_url + 'reports/fetchOrderDatabyGame/'+game_data,
        type: 'get',
        },
    // 'ajax': base_url + 'reports/fetchOrderData/'+selected_date,
    drawCallback: function () {
      var api = this.api();
      $( "#total_gross" ).html(
        this.fnSettings().fnFormatNumber(api.column( 4, {page:'current'} ).data().sum())
      );
      $( "#total_net" ).html(
        this.fnSettings().fnFormatNumber(api.column( 5, {page:'current'} ).data().sum())
      );
      $( "#total_balance" ).html(
        this.fnSettings().fnFormatNumber(api.column( 6, {page:'current'} ).data().sum())
      );
    },
    
     responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'excel', title: 'Sales by Game Report'},
                    {extend: 'pdf', title: 'Sales by Game Report'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '15px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

  });
        
  } );

});




</script>


 
