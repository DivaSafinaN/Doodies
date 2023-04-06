

<div class="taskgroup-wrap d-flex" style="height: 10vh">
    <form action="{{ route('task_groups.store') }}" method="post">
        @csrf
        <div class="wrapper d-flex mx-3">
            <div class="input-data">
                    <input type="text" name="name" id="" class="input-title">
                    <div class="underline"></div>
            </div>
            <button type="submit" class="btn save" style="align-self: flex-end">Save</button>
        </div>
    </form>
</div>
