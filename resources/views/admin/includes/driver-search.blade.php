<div class="row">
	<div class="col-md-6">
      <!-- search form -->
      <form action="{{ route('admin.search.driver') }}" method="get" role="form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search name or id...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-success"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
	</div>
</div>