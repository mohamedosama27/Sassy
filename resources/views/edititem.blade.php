@extends('bar')

@section('content')
<style>
    label {
        color: lightskyblue;
        margin:5px;
    }
    input{
        margin:10px;
    }

</style>
<script>
var form=documentElementById('upload');
var request = new XMLHttpRequest();
form.addEventLisener('submit,function(e){
    e.preventDefault();
    var formdata = new FormData(form);

    request.open('post','/createitem');
    request.addEventListener('load',transferComplete);
    request.send(formdata);
    });
    function transferComplete(data){
        console.log(data.currentTarget.response);
        
    }
</script>
{{--Form of inserting a new Item--}}

    <form method="POST" action="{{route('item.update',['id' => $item->id])}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <h1 style="color:lightskyblue;">New item</h1>

            <label for="exampleInputEmail1">Item Name</label>
            <input @if($item->name) value="{{$item->name}}"@endif type="Text" class="form-control" id="text" Name="name" placeholder="Item Name" required>
            <label for="exampleInputEmail1">Bar Code</label>
            <input @if($item->barcode) value="{{$item->barcode}}" @endif type="Text" class="form-control" id="text" Name="barcode" placeholder="Bar code" required>

            <label for="exampleInputEmail1">Description</label>
            <input @if($item->description) value="{{$item->description}}"@endif type="Text" class="form-control" id="text" Name="description" placeholder="Description">

            <label for="exampleInputEmail1">Price</label>
            <input @if($item->price) value="{{$item->price}}"@endif type="Text" class="form-control" id="text" Name="price" placeholder="EGP..." required>

            <label for="exampleInputEmail1">Quantity</label>
            <input @if($item->quantity) value="{{$item->quantity}}"@endif type="Text" class="form-control" id="text" Name="quantity" placeholder="Quantity" required>
            <label >Delete images</label>

            <table class="table">
           
            <tbody>
            @forelse($item->images as $image)
                <tr>
                <th scope="row"><img height="150" width="110" src={{ URL::asset("images/{$image->name}")}}></th>
                <td><a href="{{route('image.delete',['id' => $image->id])}}">
                <button type="button" class="btn btn-default" style="margin-bottom:10px;" style="color:black;"><b>Delete</b></button></a></td>
                </tr>
                @empty
                <p style="color:red;margin-left:50px;">No Images</p>

                @endforelse
       
            </tbody>
            </table>
            <label for="exampleInputEmail1">Add images</label>

            <div class="custom-file">
            <input type="file" class="custom-file-input" id="validatedCustomFile" Name="img[]"  accept="image/*" multiple>
            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
            </div>
            <script>
             $('.custom-file input').change(function (e) {
                var files = [];
               
                $(this).next('.custom-file-label').html("you choose : "+ $(this)[0].files.length+" images");
            });
            </script>
          

             <div class="form-group">
                    <label for="sel1" Name="category">Category</label>
                    <select class="form-control" id="sel1" Name="category">
                    @foreach($categories as $category)
                        @if($category->id==$item->category_id)
                        <option value="{{$category->id}}" selected>{{$category->name}}</option>
                        @else
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                    @endforeach
                    </select>
                    </div>
          
          

            <button type="submit" class="w3-btn btn-block w3-round-xxlarge w3-blue" style="margin-bottom:10px;">EDIT</button>


            <br>
            <br>

    </form>


@endsection
