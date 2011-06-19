<form method="post" action="transl">
	<input type="hidden" id="from" name="from" value="<?php echo $page?>"/>
    <label for="contacts">Контакты для связи(не обязательно): </label>
    <input id="contacts" name="contacts"/><br/>
    <textarea id="translation" name="translation" rows="20" cols="80"></textarea><br/>
    <input type="submit" value="Отправить"/>
</form>
