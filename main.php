<?php
/**
 * Plugin Name: change mode permission ver1.0.0
 * Description: Wordpressに書き込み権限を与えたり除去したり
 * * Author: Izumikawa
 */


  final class ChangeModeMain {
    public static $wp_dir;
    public static $mdir; 


    function __construct(){
      @session_start();
      self::$mdir =  dirname( plugin_basename( __FILE__ ) ) ;

      // 管理メニューにフックを登録
      add_action('admin_menu',array( $this, 'add_quote_setting' ) );

      add_action('admin_print_styles',  function () {
        echo '<style>.pl-1{ padding-left: 1em;} .pl-1 h4{font-size:1.15em;font-weight:600;margin-bottom:.5em;}article.pl-1 {
          padding-bottom: 2em;}pre.ta-minal {background: #333;width: 563px;padding: 1em;font-size: 1.2em;color: #0f0;font-family: "courier NEW" ,consolas;}
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

        
      }elseif(!empty( $_POST['thp'])){
        //テーマ､プラグイン ディレクトリの権限を変える
        if( $_POST['thp'] == 'Wordpress' ) {
          $this->modUnProtect();
          
        }elseif($_POST['thp'] == 'Other'){
          $this->modProtect();
          echo 'othr';
        }

      }else{
        if( !empty($_SESSION['cmdx']['results'] ))
        echo $_SESSION['cmdx']['results'] ;
      }
      
      echo $_SESSION['cmdx']['results'] ;
      $_SESSION['cmdx'] = null;
      include 'ds-form-view.php';

    }

    

    /* WPに書き込み権限を与えない*/
    public function modProtect(){
      
      shell_exec('chmod -R 570 ' .ABSPATH.'/wp-content');
      $results = shell_exec('ls -la ' .ABSPATH.'/wp-content');
      $_SESSION['cmdx']['results'] =  "<pre class='ta-minal'>$results</pre>";
    }
    
    
    
    /* WPに書き込み権限を与える*/
    public function modUnProtect(){
      shell_exec('chmod -R 770 ' .ABSPATH.'/wp-content');
      $results = shell_exec('ls -la ' .ABSPATH.'/wp-content');
      $_SESSION['cmdx']['results'] =  "<pre class='ta-minal'>$results</pre>";
    }
    
    


  }
  
  new ChangeModeMain;