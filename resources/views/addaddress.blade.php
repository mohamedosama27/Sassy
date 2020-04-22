
  <div class="modal fade" id="addaddress">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add order address</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form method="POST" action="{{route('checkout')}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
          <textarea class="form-control" Name="address" placeholder="Enter address here .." required></textarea>


   
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

        </div>
        </form>
        
      </div>
    </div>
  </div>