<?php
/**
 * Plugin Name: change mode permission ver1.0.0
 * Description: Wordpressに書き込み権限を与えたり除去したり
 * * Author: Izumikawa
 */


  final class ChangeModeMain {
    private static $wp_dir;
    protected static $mdir;


    function __construct(){
      @session_start();
      self::$mdir =  dirname( plugin_basename( __FILE__ ) ) ;

      // 管理メニューにフックを登録
      add_action('admin_menu',array( $this, 'add_quote_setting' ) );

      add_action('admin_print_styles',  function () {
        echo '<style>.pl-1{ padding-left: 1em;} .pl-1 h4{font-size:1.15em;font-weight:600;margin-bottom:.5em;}article.pl-1 {
          padding-bottom: 2em;}pre.ta-minal {background: #333;width: 800px;padding: 1em;font-size: 1.2em;color: #0f0;font-family: "courier NEW" ,consolas;}
        </style>';
      } ); 

       
    }




    /*
      メニューを追加する
    */

    public function add_quote_setting(){
      $my_plugin_slug = self::$mdir ; 
    
      // トップレベルにオリジナルのメニューを追加（購読者相当 read editor
      add_menu_page('CangeMode', 'CangeMode', 'manage_options',
          $my_plugin_slug,
          array($this,'ds_form_view'),
          plugins_url('/images/icon-admin.png', __FILE__),
          11
      );
    }

    public function ds_form_view(){

      if( !empty( $_POST['wps']) ){ 
        //wp ディレクトリの権限を変える
        if( $_POST['wps'] == 'Wordpress' ) {
          $this->wpProtect('770'); //与える
          
        }elseif($_POST['wps'] == 'Other'){
          $this->wpProtect('570'); //与えない
          echo 'other';
        }
        
      }elseif(!empty( $_POST['thp'])){
        //テーマ､プラグイン ディレクトリの権限を変える
        if( $_POST['thp'] == 'Wordpress' ) {
          $this->modProtect('770'); //与える
          
        }elseif($_POST['thp'] == 'Other'){
          $this->modProtect('570'); //与えない
          echo 'other';
        }

      }
      
      if (isset($_SESSION['cmdx']['results'])) echo $_SESSION['cmdx']['results'] ;

      $_SESSION['cmdx'] = null;
      include 'ds-form-view.php';
      
    }

    

    /* WPに書き込み権限を与えない570与える770*/
    protected function wpProtect($wpmod){
      shell_exec("chmod -R $wpmod " .ABSPATH);
      $results = shell_exec('ls -la ' .ABSPATH);
      $_SESSION['cmdx']['results'] =  "<pre class='ta-minal'>$results</pre>";
    }
    
    protected function modProtect($mod){
      shell_exec("chmod -R $mod " .ABSPATH.'/wp-content');
      $results = shell_exec('ls -la ' .ABSPATH.'/wp-content');
      $_SESSION['cmdx']['results'] =  "<pre class='ta-minal'>$results</pre>";
    }
    

  }
  
  new ChangeModeMain;