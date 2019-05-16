<?php /* Smarty version 2.6.14, created on 2007-11-06 13:45:56
         compiled from z:/home/barefoot_zend/www/application/views/frontend/directory/item_js.tpl */ ?>

<?php if ($this->_tpl_vars['UserActions']->IsAuth): ?>







<?php echo '
<script>





function changeView(view){

Item = document.getElementById(\'item\');

'; ?>
var url = "<?php echo $this->_tpl_vars['StartLink']; ?>
/directory/edit_item/?type=3&ajax=1&item_id=<?php echo $this->_tpl_vars['ItemId']; ?>
&sid=<?php echo $this->_tpl_vars['UserActions']->Sid; ?>
";<?php echo '

url += \'&view=\' + view;


var oDomDoc = Sarissa.getDomDocument();




var xmlhttp =  new XMLHttpRequest();
xmlhttp.open("GET",url,true);

//xmlhttp.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');



xmlhttp.onreadystatechange = function() {
   	 if (xmlhttp.readyState == 4) {
    
        	if(xmlhttp.status == 200){
        	loading=document.getElementById(\'loading\');
    		loading.parentNode.removeChild(loading);
	  	
           	Item.innerHTML = \'\';
			Item.innerHTML = xmlhttp.responseText;
		
			
		}



	}
}
document.body.appendChild(this.loading);	
xmlhttp.send(null);



}




function del(){
 //answer = confirm("Are you sure you want to delete this listing?", 2, 2);     
 
 var answer = prompt("Set the reason:", "")


if (answer)
{
  '; ?>
window.location.href = "?item_id=<?php echo $this->_tpl_vars['ItemId']; ?>
&sid=<?php echo $this->_tpl_vars['UserActions']->Sid; ?>
&delete=1"  + '&reason=' + answer;<?php echo '
  
}

}

function del2(){
 answer = confirm("Are you sure you want to delete this listing?", 2, 2);     
 

if (answer)
{
  '; ?>
window.location.href = "?item_id=<?php echo $this->_tpl_vars['ItemId']; ?>
&sid=<?php echo $this->_tpl_vars['UserActions']->Sid; ?>
&delete=1" ;<?php echo '
  
}

}

function submitForm(){

document.forms.form1.submit();

}
function SetActive(flag){



if(!flag){
  '; ?>
window.location.href = "?item_id=<?php echo $this->_tpl_vars['ItemId']; ?>
&sid=<?php echo $this->_tpl_vars['UserActions']->Sid; ?>
&active=1";<?php echo '

   // document.getElementById(\'active\').innerHTML = \'\';
    }
    else{
    

    
    	Field= document.getElementById(\'active_flag\');
    	Field.value = 1;
		
    	submitForm();
    
    }


}
function SetClose(){


if(confirm("Once a listing is closed, it will be removed from all search results and it cannot be made active again. Are you sure you want to close this listing?")){
  '; ?>
window.location.href = "?item_id=<?php echo $this->_tpl_vars['ItemId']; ?>
&sid=<?php echo $this->_tpl_vars['UserActions']->Sid; ?>
&close=1";<?php echo '
 // document.getElementById(\'close\').innerHTML = \'\';
 
}

}
</script>

'; ?>

<br><br>

<?php $_from = $this->_tpl_vars['UserActions']->getUserActions(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['a']):
?>
<?php if ($this->_tpl_vars['key'] != 0): ?> | <?php endif; ?>
<?php if ($this->_tpl_vars['a'] == 'publish'): ?>
<?php if ($this->_tpl_vars['UserActions']->View == 'edit'): ?>
	 <a href="#" onClick="SetActive(1)">Publish</a>
	 <?php else: ?>
	 <a href="#" onClick="SetActive(0)">Publish</a>
	 <?php endif; ?>
<?php elseif ($this->_tpl_vars['a'] == 'close'): ?>
<a href="#" onClick="SetClose()">Close</a>
<?php elseif ($this->_tpl_vars['a'] == 'edit'): ?> <a href="#" onClick="changeView('edit');return false;">Edit</a> 
<?php elseif ($this->_tpl_vars['a'] == 'view'): ?>
<a href="#" onClick="changeView('view');return false">Cancel edit</a>
<?php elseif ($this->_tpl_vars['a'] == 'save'): ?>
<a href="#" onClick="submitForm()">Save</a> 

<?php elseif ($this->_tpl_vars['a'] == 'delete_admin'): ?> <a href="#" onClick="del()">Delete</a> 
<?php elseif ($this->_tpl_vars['a'] == 'delete_user'): ?><a href="#" onClick="del2()">Delete</a> 
		
<?php endif; ?>	
<?php endforeach; endif; unset($_from); ?>

		



<br><br>
<?php endif; ?>