<div class="col-sm-12 col-md-12">
  <div class="panel">
    <div class="ratio ratio-4x3">
        <iframe src="<?=base_url("$path/$report")?>" 
                class="embed-responsive-item"></iframe>
    </div>
  </div>
</div>
<div id="noPadding"></div>
<script>
  // Own script to clear PDF's preview white margin around
  var item = document.getElementById('noPadding');
  item.parentElement.className = 'container-fluid px-0';
//   item.parentElement.className = 'container-fluid px-1';
//   item.parentElement.removeAttribute('class');
//   console.log( );
</script>
