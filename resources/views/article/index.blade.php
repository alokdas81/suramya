@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
  <table class="table table-striped">
    <tr><td><a href="{{ route('article.create')}}" class="btn btn-primary">Add</a></td></tr>
  </table>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Title</td>
          <td>Details</td>
          <td colspan="2" align="center">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($articles as $article)
        <tr>
            <td>{{$article->id}}</td>
            <td>{{$article->title}}</td>
            <td>{{$article->details}}</td>
            <td align="center"><a href="{{ route('article.edit',$article->id)}}" class="btn btn-primary">Edit</a></td>
            <td align="center">
                <form id="article-del-frm" action="{{ route('article.destroy', $article->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="button" onclick="delArticle(this.form);">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
@endsection

<script type="text/javascript">
  function delArticle(frm)
  {
    if(confirm("Are you sure want to delete this record!"))
      frm.submit();
  }
</script>