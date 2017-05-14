<?php
use yii\helpers\Html;
$this->title = 'Помощь в использовании';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="container">
    <section>
     <?=recurciveOutHelpPageSections($sections, $pages);?>
    </section>
  </div>
</main>


<?php
function recurciveOutHelpPageSections($sections, $pages)
{
  ?>
  <ul>
  <?php
  foreach($sections as $section)
  {
    ?>
    <li>
      <?=$section['name']?>
      <?php
      if(isset($section['childrens']) && $section['childrens'])
      {
        recurciveOutHelpPageSections($section['childrens'], $pages);
      }
      ?>
      <?php
      if(isset($pages[$section['id']]))
      {
        ?><ul><?php
        foreach($pages[$section['id']] as $page)
        {
          ?><li><a href="/lk/workroom/help-view/?id=<?=$page['id']?>"><?=$page['name']?></a></li><?php
        }
        ?></ul><?php
      }
      ?>
    </li>
  <?php
  }
  ?>
  </ul>
<?php
}
?>