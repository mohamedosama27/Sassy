@extends('bar')

@section('content')

  
   
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Title</th>
      <th scope="col" colspan='2'>Actions</th>
      
    </tr>
  </thead>
  <tbody>
  @foreach($categories as $category)
  <form method="POST" action="{{route('category.update',['id' => $category->id])}}" enctype="multipart/form-data">
  @csrf
    @method('PUT')
    <tr>
    
      <td>
      <input type="Text" class="form-control"Name="name" value ="{{$category->name}}" required>

      </td>
      <td> 
      <button type="submit" name="submit" class="btn btn-primary">Save</button>
      </td>
      </form>
      <td>
      <a href="{{route('category.delete',['id' => $category->id])}}"><button class="btn btn-primary">Delete</button></a>
</td>
      
    </tr>
    
    @endforeach
  </tbody>
</table>
@endsection  
     
