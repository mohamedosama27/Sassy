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

    <form method="POST" action="{{route('item.store')}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
        <h1 style="color:lightskyblue;">New item</h1>

            <label>Item Name</label>
            <input type="Text" class="form-control" id="text" Name="name" placeholder="Item Name" value="{{ old('name') }}" required>
            @error('name')
                                     <span role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span><br>
                                @enderror  
            <label>Bar Code</label>
            <input type="Text" class="form-control" id="text" Name="barcode" placeholder="Bar code" value="{{ old('name') }}" required>
            @error('barcode')
                                     <span role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span><br>
                                @enderror  
            <label >Description</label>
            <input type="Text" class="form-control" id="text" Name="description" placeholder="Description" value="{{ old('description') }}">
            @error('Description')
                                     <span role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span><br>
                                @enderror  
            <label for="exampleInputEmail1">Price</label>
            <input type="Text" class="form-control" id="text" Name="price" placeholder="EGP..." value="{{ old('price') }}" required>
            @error('price')
                                     <span role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span><br>
                                @enderror
            <label for="exampleInputEmail1">Quantity</label>
            <input type="Text" class="form-control" id="text" Name="quantity" placeholder="Quantity" value="{{ old('quantity') }}" required>
            @error('quantity')
                                     <span role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span><br>
                                @enderror
            <label for="exampleInputEmail1">Choose images</label>
            
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
                    <label for="sel1" Name="Category">Category</label>
                    <select class="form-control" id="sel1" Name="category">
                    <option value="" disabled selected>Choose your option</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                    </select>
                    </div>
                    <button type="submit" class="w3-btn btn-block w3-round-xxlarge w3-blue" style="margin-bottom:10px;">ADD</button>

            <br>
            <br>

    </form>


@endsection
