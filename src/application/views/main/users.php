<div class="container">

<div class="row mt-4">
<div class="col-12">
    <form id="user_form">
        <div class="mb-3">
        <label for="input_id" class="form-label">Id</label>
        <input type="text" class="form-control" id="input_id">
        </div>

        <div class="mb-3">
        <label for="input_first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" id="input_first_name">
        </div>

        <div class="mb-3">
        <label for="input_second_name" class="form-label">Second Name</label>
        <input type="text" class="form-control" id="input_second_name">
        </div>

        <div class="mb-3">
        <label for="select_position" class="form-label">Position</label>
        <select class="form-control" id="select_position">
            <option value="developer">Developer</option>
            <option value="manager">Manager</option>
            <option value="tester">Tester</option>
        </select>
        </div>
    </form>
    <button id="save_user_button" type="button" class="btn btn-primary">Save user</button>
</div>
</div>

<div class="row mt-4">
<div class="col-12">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">First Name</th>
      <th scope="col">Second Name</th>
      <th scope="col">Position</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody id="users_table">
  </tbody>
</table>
</div>
</div>

</div>

<script src="/js/users.js"></script>
