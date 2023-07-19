<style>
   .error  .form-control{
        height: auto !important;
   }
   .error .input-group{
    width: 80%;
   }
</style>
<form action="{{ route('searchResults') }}" method="GET">
    <div class="form-group floating-addon floating-addon-not-append my-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-search"></i>
                </div>
            </div>
            <input type="text" class="form-control" placeholder="Search" name="keyword">
            <div class="input-group-append">
                <button class="btn btn-lg btn-theme" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>