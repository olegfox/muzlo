<?php


Class Excel_Parse
{

	public function __construct ( $file )
	{

		empty ( $file[0] ) && die('wrong excel construct');

		$dir = $_SERVER['DOCUMENT_ROOT'] . '/application/excel/';

		$fileName = $dir . $file[0];

		! is_file ( $fileName ) && die ( 'Excel File "' . $file[0] . '" Not Found! Please keep it to ' . $dir );

		require_once 'excel/PHPExcel/PHPExcel/IOFactory.php';

		$this->fileName = $fileName;

	}

	public function getExcelDir ()
	{

		return str_replace ( $_SERVER['DOCUMENT_ROOT'], '', $this->fileName );

	}


	public function getArray ()
	{

			# Start Lib
			$objPHPExcel = PHPExcel_IOFactory::load( $this->fileName );
			$objPHPExcel->setActiveSheetIndex(0);
			$aSheet      = $objPHPExcel->getActiveSheet();

			# Собрать массивы
			$rows 	= 	array();
			$i 		=	0;

			foreach($aSheet->getRowIterator() as $row)
			{

				$cellIterator = $row->getCellIterator();

				foreach($cellIterator as $cell) :
					( $cell->getCalculatedValue() <> '' ) ? $rows[$i][] = trim ( $cell->getCalculatedValue() ) : FALSE;
				endforeach;

			    $i++;

			}


			if ( ! empty ( $rows[0] ) )
			{

				$rows['cols'] = $rows[0];
				unset($rows[0]);

			}

			$newRows = array();

			foreach ( $rows as $k => $v )
			{

				if ( 'cols' !== $k )
				{

					foreach ( $v as $a => $b ) :
						! empty ( $rows['cols'][$a] ) && $newRows[$k][$rows['cols'][$a]] = $b;
					endforeach;

				}

			}

			return $newRows;
	}

}