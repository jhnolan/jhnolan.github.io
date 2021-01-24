<html>
  <head></head>
  <body>
    <h2>Search</h2>
    <form method="post">
      Search: <input type="text" name="q" />
    </form>
 
    <?php
    // if form submitted
    if (isset($_POST['q'])) {
      // load Zend classes
      require_once 'Zend/Loader.php';
      Zend_Loader::loadClass('Zend_Rest_Client');
 
      try {
        // initialize REST client
        $wikipedia = new Zend_Rest_Client('http://en.wikipedia.org/w/api.php');
 
        // set query parameters
        $wikipedia->action('query');
        $wikipedia->list('search');
        $wikipedia->srwhat('text');
        $wikipedia->format('xml');
        $wikipedia->srsearch($_POST['q']);
 
        // perform request
        // iterate over XML result set
        $result = $wikipedia->get();
      } catch (Exception $e) {
          die('ERROR: ' . $e->getMessage());
      }
    ?>
    <h2>Search results for '<?php echo $_POST['q']; ?>'</h2>
    <ol>
    <?php foreach ($result->query->search->p as $r): ?>
      <li><a href="http://www.wikipedia.org/wiki/
      <?php echo $r['title']; ?>">
      <?php echo $r['title']; ?></a> <br/>
      <small><?php echo $r['snippet']; ?></small></li>
    <?php endforeach; ?>
    </ol>
    <?php
    }
    ?>
 
  </body>
</html>