@if ($message = Session::get('success'))
<div class="alert alert-success alert_msg">
      <span>{{ $message }}</span>
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  </div>
@endif
