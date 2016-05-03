
/**
 * 
 * Nf_pp
 */

 //<![CDATA[

function nf_pp_init( id, autoCollapsed, autoOpen ){

	var
		sigMinus        = '(&minus;) ',
		sigPlus         = '(+) ',
		sigDiabled      = '(&nbsp;)',
		sigCollapseCh   = '(#num#)',
		classMinus      = 'pp_ctrlMinus',
		classPlus       = 'pp_ctrlPlus',
		classDisabled   = 'pp_ctrlDisabled',
		classCollapseCh = 'pp_ctrlCollapseCh',
		classKey        = 'pp_key',
		classRoot       = 'pp_tree';


	var tree = document.getElementById( id );
	applyCtrlRec( tree, autoCollapsed );
	
	if( autoOpen.length )
		autoOpenTree( tree, autoOpen );
		
		
	/**
	 *  Recursively adds controls to every LI-node that has UL-child
	 */
	function applyCtrlRec( ul, autoCollapsed ){

		var arLi = ul.children;

		for( var c = arLi.length - 1; c >= 0; c-- ){

			var curLi = arLi[c],
				chUl    = getChildUl( curLi );
			
			if( chUl !== false ){

				addCtrl( curLi, autoCollapsed ? 0 : 1 );
				if( autoCollapsed )
					chUl.style.display = 'none';
				
				applyCtrlRec( chUl, autoCollapsed );
			
			}
			else{
			
				addCtrl( curLi, 2 );
			
			}
		
		}
	
	}


	/**
	 *  Returns child div or false if not found
	 *  @param li parent node
	 */
	function getChildUl( li ){
	
		var children = li.children;
		
		for( var c = children.length - 1; c >= 0; c-- )
			if( children[c].nodeName == 'UL' )
				return children[c];
				
		return false;
	
	}
	
	
	/**
	 *  Adds control to current li
	 */
	function addCtrl( li, state ){
	
		switch( state ){
			
			case 0:  //  collapsed
				var sign   = sigPlus,
					actClass = classPlus;
				break;
				
			case 1:  //  opened
				var sign   = sigMinus,
					actClass = classMinus;
				break;
				
			case 2:  //  disabled
				var sign   = sigDiabled,
					actClass = classDisabled;
				break;
		
		}

		var ctrl = document.createElement( 'i' );
		ctrl.setAttribute( 'title', 'Fold/unfold' );
		ctrl.innerHTML = sign;
		ctrl.className = 'pp_ctrl ' + actClass;
		applyHdlr( ctrl, ctrlHandler );

		li.insertBefore( ctrl, li.firstChild );
		
		
		//  collapse children
		if( state == 0 || state == 1 ){
		
			var arI = li.children,
				ctrl = false;

			for( var c = arI.length - 1; c >= 0; c-- ){
				if( arI[c].className.indexOf( classCollapseCh ) != -1 ){
					ctrl = arI[c];
					break;
				}
			}

			if( ctrl );
				applyHdlr( ctrl, collapseChHandler );
			
		}

	}
	
	
	/**
	 *  Adds onClick-handler to control
	 */
	function applyHdlr( target, handler, type ){
	
		type = type || 'click';

		if (target.addEventListener)
			target.addEventListener( type, handler, false );
		else
			target.attachEvent( 'on' + type, function(){ handler.call( target ) } );
	
	}
	
	
	/**
	 *  Handler that handles clicks on controls (+/-)
	 */
	function ctrlHandler(){
		
		var ul = getChildUl( this.parentNode ),
			className = this.className;

		if( ul ){
		
			if( this.className.indexOf( classMinus ) >= 0 )
				closeNode( this );
			else
				openNode( this );
				
		}
	
	}
	

	/**
	 *  Handler that handles collapse children
	 */	
	function collapseChHandler(){

		var
			arLi = getChildUl( this.parentNode ).children,
			collapse = false;
		
		//  determine open or collapse children
		for( var c = arLi.length - 1; c >= 0; c-- ){

			if( arLi[c].firstChild.className.indexOf( classMinus ) >= 0 ){
				collapse = true;
				break;
			}
			
		}

		for( var c = arLi.length - 1; c >= 0; c-- ){

			if( getChildUl( arLi[c] ) ){
			
				if( collapse )
					closeNode( arLi[c].firstChild );
				else
					openNode( arLi[c].firstChild );
				
			}
		
		}
	
	}
		
	
	function closeNode( ctrl ){
	
		var ul = getChildUl( ctrl.parentNode ),
			className = ctrl.className;
		
		if( ! ul )
			return;
	
		ul.style.display = 'none';
		ctrl.className = className.replace( classMinus, classPlus );
		ctrl.innerHTML = sigPlus;
	
	}
	
	
	function openNode( ctrl ){
	
		var ul = getChildUl( ctrl.parentNode ),
			className = ctrl.className;
		
		if( ! ul )
			return;
	
		ul.style.display = 'block';
		ctrl.className = className.replace( classPlus, classMinus );
		ctrl.innerHTML = sigMinus;
	
	}
	
	
	function autoOpenTree( ul, autoOpen ){
	
		var arSpan = ul.getElementsByTagName( 'SPAN' ),
			arToOpen = [];
		
		for( var c = arSpan.length - 1; c >= 0; c-- ){
		
			var curSpan = arSpan[c];
			
			if( curSpan.className.indexOf( classKey ) < 0 )
				continue;
				
			for( var q = autoOpen.length - 1; q >= 0; q-- ){
			
				var rx = new RegExp( '\\['+autoOpen[q]+'(:<span[^<]*</span>)?\\]', 'i' );
				
				if( curSpan.innerHTML.search( rx ) != -1 ){
					arToOpen.push( curSpan.previousSibling );
					break;
				}
			
			}
		
		}
		
		for( var c = arToOpen.length - 1; c >= 0; c-- )
			openNodeRec( arToOpen[c] );
	
	}
	
	
	function openNodeRec( ctrl ){

		openNode( ctrl );
		
		var parent = ctrl.parentNode.parentNode;  //  parent ul
		
		if( parent.className == classRoot )
			return;
			
		ctrl = parent.parentNode.firstChild;
		openNodeRec( ctrl );
	
	}

}

//]]>
