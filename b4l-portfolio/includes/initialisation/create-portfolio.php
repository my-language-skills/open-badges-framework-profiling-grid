<?php

function create_student_portfolio_callback(){
  ?>
    <table cellpadding="10">
      <tr>
        <td><h3>Select Portfolio Type:</h3></td>
        <td><input type="radio" name="p_type" value="student"> Student<br></td>
        <td><input type="radio" name="p_type" value="teacher`"> Teacher<br></td>
      </tr>
      <tr>
        <td><h3>Select Learning Language:</h3></td>
        <td>
          <select>
            <option value="no">  Select</option>
            <option value="eng">English</option>
            <option value="spa">Spanish</option>
            <option value="chi">Chinese</option>
            <option value="arab">Arabic</option>
          </select>
        </td>
      </tr>
      <tr>
        <td><h3>Select Portfolio Language:</h3></td>
        <td>
          <select>
            <option value="no">  Select</option>
            <option value="eng">English</option>
            <option value="spa">Spanish</option>
            <option value="chi">Chinese</option>
            <option value="arab">Arabic</option>
          </select>
        </td>
      </tr>
      <tr>
        <td><button>Create Portfolio</button></td>
      </tr>
    </table>
<?php
}

 ?>
