$( document ).ready( function () {
  $( '#material-tabs' ).each( function () {
    var $active, $content, $links = $( this ).find( 'a' );
    var tab = sessionStorage.getItem( "tab" );
    // console.log($links);
    if ( tab != null ) {
      if ( tab == "tab2-tab" ) {
        $active = $( $links[ 1 ] );
      } else if ( tab == "tab3-tab" ) {
        $active = $( $links[ 2 ] );
      } else {
        $active = $( $links[ 0 ] );
      }
    } else {
      $active = $( $links[ 0 ] );
    }
    // $active = $($links[0]);
    $active.addClass( 'active' );

    $content = $( $active[ 0 ].hash );

    $links.not( $active ).each( function () {
      $( this.hash ).hide();
    } );

    $( this ).on( 'click', 'a', function ( e ) {
      console.log(e.currentTarget.id);
      sessionStorage.setItem( "tab", e.currentTarget.id);
      $active.removeClass( 'active' );
      $content.hide();

      $active = $( this );
      $content = $( this.hash );

      $active.addClass( 'active' );
      $content.show();

      e.preventDefault();
    } );
  } );
} );
( function ( $ ) {
  'use strict';
  $( function () {
    $( ".preloader" ).fadeOut();
  } );
  // $( function () {
  //   var body = $( 'body' );
  //   var sidebar = $( '.sidebar' );

  //   function addActiveClass( element ) {

  //     if ( element.attr( 'href' ).indexOf( current ) !== -1 ) {
  //       element.parents( '.nav-item' ).last().addClass( 'active' );
  //       if ( element.parents( '.sub-menu' ).length ) {
  //         element.closest( '.collapse' ).addClass( 'show' );
  //         element.closest( '.nav-item' ).addClass( 'sub-active' );
  //         element.addClass( 'active' );
  //       }
  //       if ( element.parents( '.submenu-item' ).length ) {
  //         element.addClass( 'active' );
  //       }
  //     }
  //   }
  //   // console.log(location.href);
  //   // console.log((location.href.split("?").slice(-1)[0].replace(/^\/|\/$/g, '')).split("&").slice(0)[0]);
  //   // var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
  //   var current = ( location.href.split( "?" ).slice( -1 )[ 0 ].replace( /^\/|\/$/g, '' ) ).split( "&" ).slice( 0 )[ 0 ];
  //   $( '.nav li a', sidebar ).each( function () {
  //     var $this = $( this );
  //     addActiveClass( $this );
  //   } )

  //   $( '.horizontal-menu .nav li a' ).each( function () {
  //     var $this = $( this );
  //     addActiveClass( $this );
  //   } )

  //   //Close other submenu in sidebar on opening any

  //   sidebar.on( 'show.bs.collapse', '.collapse', function () {
  //     sidebar.find( '.collapse.show' ).collapse( 'hide' );
  //   } );


  //   //Change sidebar and content-wrapper height
  //   applyStyles();

  //   function applyStyles() {
  //     //Applying perfect scrollbar
  //     if ( !body.hasClass( "rtl" ) ) {
  //       if ( $( '.settings-panel .tab-content .tab-pane.scroll-wrapper' ).length ) {
  //         const settingsPanelScroll = new PerfectScrollbar( '.settings-panel .tab-content .tab-pane.scroll-wrapper' );
  //       }
  //       if ( $( '.chats' ).length ) {
  //         const chatsScroll = new PerfectScrollbar( '.chats' );
  //       }
  //       if ( body.hasClass( "sidebar-fixed" ) ) {
  //         if ( $( '#sidebar' ).length ) {
  //           var fixedSidebarScroll = new PerfectScrollbar( '#sidebar .nav' );
  //         }
  //       }
  //     }
  //   }

  //   $( '[data-toggle="minimize"]' ).on( "click", function () {
  //     if ( ( body.hasClass( 'sidebar-toggle-display' ) ) || ( body.hasClass( 'sidebar-absolute' ) ) ) {
  //       body.toggleClass( 'sidebar-hidden' );
  //     } else {
  //       body.toggleClass( 'sidebar-icon-only' );
  //     }
  //   } );

  //   //checkbox and radios
  //   $( ".form-check label,.form-radio label" ).append( '<i class="input-helper"></i>' );

  //   //Horizontal menu in mobile
  //   $( '[data-toggle="horizontal-menu-toggle"]' ).on( "click", function () {
  //     $( ".horizontal-menu .bottom-navbar" ).toggleClass( "header-toggled" );
  //   } );
  //   // Horizontal menu navigation in mobile menu on click
  //   var navItemClicked = $( '.horizontal-menu .page-navigation >.nav-item' );
  //   navItemClicked.on( "click", function ( event ) {
  //     if ( window.matchMedia( '(max-width: 991px)' ).matches ) {
  //       if ( !( $( this ).hasClass( 'show-submenu' ) ) ) {
  //         navItemClicked.removeClass( 'show-submenu' );
  //       }
  //       $( this ).toggleClass( 'show-submenu' );
  //     }
  //   } )

  //   $( window ).scroll( function () {
  //     if ( window.matchMedia( '(min-width: 992px)' ).matches ) {
  //       var header = $( '.horizontal-menu' );
  //       if ( $( window ).scrollTop() >= 70 ) {
  //         $( header ).addClass( 'fixed-on-scroll' );
  //       } else {
  //         $( header ).removeClass( 'fixed-on-scroll' );
  //       }
  //     }
  //   } );
  // } );

} )( jQuery );