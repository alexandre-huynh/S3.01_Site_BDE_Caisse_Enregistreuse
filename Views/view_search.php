<?php require "view_begin.php";?>

 <form action = "?controller=search&action=form">
   <p>
     <label> Name contains: <input type="text" name="name"/> </label>
   </p>
   <p>
     <label> Year:
        <select name="sign">
          <option value="<="><=</option>
          <option value=">=">>=</option>
          <option value="==">==</option>
        </select>
        <input type="text" name="year"/>
     </label>
   </p>
   <p>
     <input type="submit" value="Search"/>
   </p>
 </form>

<?php require "view_end.php";?>
