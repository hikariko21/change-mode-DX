<?php
  $writable = is_writable( ABSPATH."/wp-content") ;
  $checked = array_fill(0,2,'');
  if( $writable ){
    $checked[0] = 'checked';
  }else{
    $checked[1] = 'checked';
  }
  $ckindex = 0;
?>

<div class="conteiner">
  <div class="row cmdx">
    <section class="col-8">
        <h3>現在の書き込み権限</h3>

      <form action="" method="post">
        <article class="pl-1">
          <h4>Wordpress</h4>  
          <p  class="pl-1">
            <label><input type="radio" name="wps" value="Wordpress" >Wordpress</label>
            <label><input type="radio" name="wps" value="Other" >Other</label>
            <button type="submit">変更する</button>
          </p>
        </article>
      </form>

      <form action="" method="post">
        <article class="pl-1">
          <h4>uploads & theme & plugin</h4>  
          <p class="pl-1">
            <label><input type="radio" name="thp" value="Wordpress" <?=$checked[$ckindex]?>>Wordpress</label>
            <label><input type="radio" name="thp" value="Other" <?=$checked[++$ckindex]?>>Other</label>
            <button type="submit">変更する</button>
          </p>
        </article>
      </form>

    </section>
  </div>
</div>