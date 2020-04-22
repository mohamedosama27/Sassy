
  <div class="modal fade" id="addcategory">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create Category</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form method="POST" action="{{route('category.store')}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="exampleInputEmail1">Category Title</label>
            <input type="Text" class="form-control" id="text" Name="name" placeholder="Enter title here .." required>


   
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