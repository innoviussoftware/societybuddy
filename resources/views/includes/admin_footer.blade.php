@role(['admin','sub_admin'])
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
    </div>
    <strong>Copyright &copy; 2019 <a href="{{ env('APP_URL') }}/admin">{{ env('APP_NAME') }}</a>.</strong> All rights reserved.
  </footer>
@endrole

@role('society_admin')
  <footer class="main-footer" style="margin-left:0px;">
    <div class="pull-right hidden-xs">
    </div>
    <strong>Copyright &copy; 2019 <a href="{{ env('APP_URL') }}/admin">{{ env('APP_NAME') }}</a>.</strong> All rights reserved.
  </footer>
@endrole
