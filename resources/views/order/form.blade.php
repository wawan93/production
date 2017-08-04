<div class="panel-body">

    @include('common.errors')

    <form action="{{ url('order') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="order-team_id" class="col-sm-3 control-label">team ID</label>

            <div class="col-sm-6">
                <input type="text" name="team_id" id="order-team_id" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add
                </button>
            </div>
        </div>
    </form>
</div>