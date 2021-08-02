

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color:white;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Records</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Records</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
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
            <h3 class="box-title">Add Records</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('records/create') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <h5 class="text-danger"><?php echo $this->session->flashdata('item'); ?></h5>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="supplier">Game</label>
                            <select class="form-control select_group" id="game" name="game">
                            <option disabled selected>.....Choose Game.......</option>
                              <?php foreach ($game as $k => $v): ?>
                                <option value="<?php echo $v['id'] ?>"><?php echo $v['name_of_game'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                          <label for="draw">Winning Draw</label>
                          <input type="text" class="form-control" id="draw" name="draw" value="<?php echo set_value('draw'); ?>" autocomplete="off"  />
                      </div>
                    </div>

                    
                
                </div>
                <div class="row">

                <div class="col-lg-6">
                      <div class="form-group">
                          <label for="wholesale_price">Gross Amount</label>
                          Ghc<input type="text" class="form-control" data-type="currency" id="gross_amount" min="0" name="gross_amount"  value="<?php echo set_value('gross_amount'); ?>" autocomplete="off"  />
                      </div>
                </div>
        
                  
                <div class="col-lg-6">
                      <div class="form-group">
                          <label for="books_no">No of Books</label>
                          <input type="number" class="form-control" id="books_no" min="1" name="books_no" value="<?php echo set_value('books_no'); ?>" autocomplete="off"  />
                      </div>
                </div>

                </div>

                <div class="row">

                <div class="col-lg-6">
                      <div class="form-group">
                          <label for="books_no">Total Wins</label>
                          <input type="text" class="form-control" id="wins_no" min="1" name="wins_no" value="<?php echo set_value('wins_no'); ?>" autocomplete="off"  />
                      </div>
                </div>

                <div class="col-lg-6">
                        <div class="form-group">
                            <label for="supplier">Unit</label>
                            <select class="form-control select_group" id="unit" name="unit">
                              <?php foreach ($unit as $k => $v): ?>
                                <option value="<?php echo $v['id'] ?>"><?php echo $v['unit_value'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                </div>

                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <?php if($check == 1){
                  ?>
                  <p style="color:red; font-size:30px;">Record for Today Has already been added, see you tomorrow</p>
                  <button type="button" class="btn btn-danger btn-lg" disabled>Disabled</button>
                  <?php
                }
                else{
                  ?>
                   <button type="submit" id="submit"class="btn btn-primary btn-lg">Save</button>
                  <?php
                }
                ?>
               
                <a href="<?php echo base_url('records/') ?>" class="btn btn-warning btn-lg">Back</a>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>

      <!-- <div class="main">
  <h1>Auto Formatting Currency</h1>
  
  <form action="<?php //base_url('records/create') ?>" method="post" enctype="multipart/form-data">
  <label for="currency-field">Enter Amount</label>
  <input type="text" name="currency-field" id="currency-field" pattern="^\d{1,3}(,\d{3})*(\.\d+)?" value="" data-type="currency" placeholder="Ghc 1,000,000.00">
  <button type="submit">Submit</button>
</form>

<p>Auto format currency input field with commas and decimals if needed. Text is automatically formated with commas and cursor is placed back where user left off after formatting vs cursor moving to the end of the input. Validation is on KeyUp and a final validation is done on blur.</p>

<p>To use just add the following to an input field:</p>
  
 <pre>data-type="currency"</pre>
  
</div> -->
<!-- /main -->


      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {


    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainrecordsNav").addClass('active');
    $("#addRecordNav").addClass('active');

    
   
  });



  $("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val = left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val = input_val;
    
    // final formatting
    if (blur === "blur") {
      input_val += ".00";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}

</script>