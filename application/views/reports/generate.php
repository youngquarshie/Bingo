

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Generate Weekly Report 
      <small>Reports</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Weekly Report</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
    
    <br />
    <div class="col-md-12 col-xs-12">
          <div class="form-group">
          <?php 

          if($check == 'error'){
            ?>
            <p style="color:red; font-size:30px;">Weekly Reports can only be generated on Saturday</p>
            <button type="submit" disabled readonly class="btn btn-danger btn-block btn-lg">Not Available</button> 
            <?php
          }
          else{
            
              ?>
                <button type="submit" id="generate" class="btn btn-primary btn-block btn-lg">Generate</button>   

              <?php
          }
          ?>
          </div>
            
    </div>

        

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
  $("#generatereportNav").addClass('active');

  // #myInput is a <input type="text"> element
  $('#generate').on( 'click', function () {

    $.ajax({
        
        url: base_url + 'reports/fetchOrderData/',
        type: 'get',
        success:function(result){
            //alert(result);
            if(result){

                alert('Report Generated Succesffully');
                window.location.href=base_url + 'reports/weekly_reports';
            }
        }

    });
    
    
  });
        
  });





</script>


 
