<?
/**
 * nf_pp
 * 
 * The class is designed to emulate function "print_r" with some additional
 *   features, such as:
 *     - highlight data types;
 *     - highlight properties scope;
 *     - visualize values of the boolean and NULL variables;
 *     - show resource type;
 *     - trim long strings;
 *     - fold nodes in arrays and objects;
 *     - fold whole tree or unfold tree to a certain key;
 *     - print elapsed time between function calls.
 * 
 * @author MAYDOKIN Aleksey
 * @version 1.3.0
 */
class nf_pp {

	public
		$trimString    = 100,
		$autoCollapsed = FALSE,
		$autoOpen      = array();
	
	protected static
		$jsFuncDisp   = FALSE,
		$cssDisp      = FALSE,
		$lastCallTime = 0;

	const TRACE_DEPTH = 0;  //  how many wrap functions has pp-method ( except pp-function )


	function __construct(){

		$options = func_get_args();
		$options = call_user_func_array( array( __CLASS__, 'parseOptions' ), $options );
	
		if( isset( $options['trimString'] ) )
			$this->trimString = intval( $options['trimString'] );
		
		if( isset( $options['autoCollapsed'] ) )
			$this->autoCollapsed = $options['autoCollapsed'];
		
		if( isset( $options['autoOpen'] ) ){
		
			$options['autoOpen'] = (array)$options['autoOpen'];
		
			$this->autoOpen      = $options['autoOpen'];
			$this->autoCollapsed = TRUE;
		
		}
	
	}
	
	
	/**
	 *  Guesses the options
	 */
	function parseOptions(){
	
		$options = func_get_args();

		if( sizeof( $options ) == 0 )  //  default
			return $options;
		
		if( is_array( $options[0] ) )  //  trivial options
			return $options[0];
		
		$newOptions = array();
		
		foreach( $options as $opt ){
		
			switch( gettype( $opt ) ){
		
				case 'boolean':
					$newOptions['autoCollapsed'] = $opt;
					break;

				case 'integer':
					$newOptions['trimString'] = $opt;
					break;
					
				case 'string':
				case 'array':
					$newOptions['autoOpen'] = $opt;
					break;
					
			}
		
		}
		
		return $newOptions;
	
	}

	function pp( $val, $curLevel = 0, $key = NULL ){
	
	ob_start();

		if( $curLevel == 0 ){
			//$this->timestamp();
			$md5 = md5( serialize($val).rand() );
			echo '<ul id="pp_'.$md5.'" class="debug_obj">';
		}
			
		echo '<li class="pp_item">';
		
		if( $key !== NULL )
			echo ' [<span class="pp_key">'.$key.'</span>] => ';

		//  determine type of the variable
		switch( gettype( $val ) ){
		
			case 'boolean':
				$this->p_bool( $val );
				break;

			case 'NULL':
				$this->p_null( $val );
				break;
				
			case 'integer':
			case 'double':
			case 'float':
				$this->p_basic( $val );
				break;
				
			case 'string':
				$this->p_string( $val );
				break;
				
			case 'array':
				$this->p_array( $val );
				break;
			
			case 'object':
				$this->p_object( $val );
				break;
				
			case 'resource':
				$this->p_res( $val );
				break;
			
			default:
				$this->p_unknown( $val );
		
		}
	
		echo '</li>';
		
		if( $curLevel == 0 ){
			echo '</ul>';
			$this->p_css();
			$this->p_jsfunc();
			$this->p_jsinit( 'pp_'.$md5 );
		}

		$out = ob_get_contents();

		ob_end_clean();

		return $out;

	}
	
	
	protected function p_bool( $val ){
	
		echo '<span class="pp_bool">'.strtoupper( var_export( $val, TRUE ) ).'</span>';
	
	}
	
	protected function p_null( $val ){
	
		echo '<span class="pp_null">Входящая переменная пуста</span>';
	
	}
	
	protected function p_basic( $val ){
	
		echo '<span class="pp_num">'.$val.'</span>';
	
	}
	
	protected function p_string( $val ){
	
		$val = htmlspecialchars( $val );
		if( $this->trimString > 0 && strlen( $val ) > $this->trimString ){
		
			if( $this->trimString > 3 )
				$val = substr( $val, 0, $this->trimString - 3 ).'...';
			else
				$val = substr( $val, 0, $this->trimString );
			
		}
		
		echo '<span class="pp_string">'.$val.'</span>';
	
	}
	
	protected function p_array( $val ){
	
		$size = sizeof( $val );
	
		echo '<span class="pp_array">Array</span><i class="pp_ctrl pp_ctrlCollapseCh" title="Fold/unfold children">('.$size.')</i><ul class="pp_subtree">';
		
		if( $size ){
		
			foreach( $val as $k => $v )
				echo $this->pp( $v, $curLevel + 1, htmlspecialchars( $k ) );
				
		}
		else{
		
			echo '<li class="pp_item"><span class="pp_empty">EMPTY</span></li>';
			
		}
		echo '</ul>';
	
	}
	
	protected function p_object( $val ){
	
		$className = get_class( $val );
		$val = (array)$val;
		$size = sizeof( $val );
		
		echo '<span class="pp_object">Object &lt;'.$className.'&gt;</span><i class="pp_ctrl pp_ctrlCollapseCh" title="Fold/unfold children">('.$size.')</i><ul class="pp_subtree">';
		
		if( $size ){
		
			foreach( $val as $k => $v ){
					
				if( strpos( $k, chr(0).$className.chr(0) ) === 0 ){
					$k = str_replace( chr(0).$className.chr(0), '', $k );
					$k = htmlspecialchars( $k ).':<span class="pp_scope pp_scope_private">private</span>';
				}
				elseif( strpos( $k, chr(0).'*'.chr(0) ) === 0 ){
					$k = str_replace( chr(0).'*'.chr(0), '', $k );
					$k = htmlspecialchars( $k ).':<span class="pp_scope pp_scope_protected">protected</span>';
				}
				else{
					$k = htmlspecialchars( $k ).':<span class="pp_scope pp_scope_public">public</span>';
				}
				
				echo $this->pp( $v, $curLevel + 1, $k );
				
			}
			
		}
		else{
		
			echo '<li class="pp_item"><span class="pp_empty">EMPTY</span></li>';
			
		}
		
		echo '</ul>';
	
	}
	
	protected function p_res( $val ){
	
		echo '<span class="pp_resource">'.$val.' &lt;'.get_resource_type( $val ).'&gt;</span>';
	
	}
	
	protected function p_unknown( $val ){
	
		echo '<span class="pp_unknown">"'.$val.'"</span>';
	
	}

	/**
	 *  Prints a mark before the tree
	 */
	protected function backtrace(){
	
		$backtrace = debug_backtrace();
		
		if( $backtrace[2]['function'] == 'pp' )
			$arToPrint = $backtrace[2 + self::TRACE_DEPTH];  //  run as a function
		else
			$arToPrint = $backtrace[1 + self::TRACE_DEPTH];  //  run as a method

		echo '<div class="pp_mark">'.$arToPrint['file'].' <span title="Line number">'.$arToPrint['line'].'</span></div>';
	
	}
	
	
	/**
	 *  Prints elapsed time between function calls.
	 */
	protected function timestamp(){
	
		$curTime = microtime( TRUE );
		
		echo '<div class="pp_mark" title="Elapsed time between function calls">';
		
		if( self::$lastCallTime > 0 )
			echo 'Время обработки массивов: ' . ( $curTime - self::$lastCallTime ).' сек.';
		else
			echo '';
			
		echo '</div>';

		self::$lastCallTime = $curTime;

	}
	
	protected function p_jsfunc(){
	
		if( self::$jsFuncDisp )
			return;
		else
			self::$jsFuncDisp = TRUE;
	
		//echo '<script src="/application/templates/js/nf_pp.js"></script>';
	
	}
	
	
	protected function p_jsinit( $id ){
	
		echo '<script type="text/javascript"> nf_pp_init( "'.$id.'", '.( $this->autoCollapsed ? 'true': 'false' ).', '.json_encode( $this->autoOpen ).' );</script>';
	
	}
	
	
	protected function p_css(){
	
		if( self::$cssDisp )
			return;
		else
			self::$cssDisp = TRUE;
	
		//echo '<link rel="stylesheet" type="text/css" href="/application/templates/css/nf_pp.css" />';
	
	}
	
}


function pp(){

	$options = func_get_args();
	$val = array_shift( $options );  //  trim first argument

	//  crazy thing to call constructor with variable arguments number
	$reflection = new ReflectionClass( 'nf_pp' );
	$pp = $reflection->newInstanceArgs( $options );

	$pp->pp( $val );
	unset( $pp, $reflection, $val, $options );

}