<?php
/*  XML  */
class X2A {

	var $ar_src;
	var $ar_idx;
	var $elid;


	function parse($src){
		$xml_parser = xml_parser_create();
		xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);
		xml_parser_set_option($xml_parser,XML_OPTION_SKIP_WHITE,1);
		xml_parse_into_struct($xml_parser, $src, $this->ar_src );
		xml_parser_free($xml_parser);

		$out= $this->getXMLElement(0);

		$root= $this->ar_src[0]['tag'];
		$out=$out[$root];
		unset($this->ar_src);

		return $out;
	}


	function getXMLElement($elm){
		$newelm=array();

		$this->elid=$elm;

		while($this->elid < count($this->ar_src)){
			if($this->ar_src[$this->elid]['type']=='open'){

				if(isset($newelm[$this->ar_src[$this->elid]['tag']])){
					if(!isset($newelm[$this->ar_src[$this->elid]['tag']][0])){
						$tarray=$newelm[$this->ar_src[$this->elid]['tag']];
						$newelm[$this->ar_src[$this->elid]['tag']]=array();
						$newelm[$this->ar_src[$this->elid]['tag']][]=$tarray;
					}
					$newelm[$this->ar_src[$this->elid]['tag']][]=$this->getXMLElement(++$this->elid);
				}
				else{
					$newelm[$this->ar_src[$this->elid]['tag']]=$this->getXMLElement(++$this->elid);
				}

			}
			else if($this->ar_src[$this->elid]['type']=='complete'){

				if(isset($newelm[$this->ar_src[$this->elid]['tag']])){
					if(!is_array($newelm[$this->ar_src[$this->elid]['tag']])){
						$tarray=$newelm[$this->ar_src[$this->elid]['tag']];
						$newelm[$this->ar_src[$this->elid]['tag']]=array();
						$newelm[$this->ar_src[$this->elid]['tag']][]=$tarray;
					}
					$newelm[$this->ar_src[$this->elid]['tag']][]=$this->ar_src[$this->elid]['value'];
				}
				else{
					$newelm[$this->ar_src[$this->elid]['tag']]=$this->ar_src[$this->elid]['value'];
				}

				$this->elid++;
			}
			else if($this->ar_src[$this->elid]['type']=='close'){
				$this->elid++;
				break;
			}

		}

		return $newelm;
	}

}// X2A END

/* A2X */
class A2X {

	function arr2xml($arr,$name=''){
		$xml='';

		foreach($arr as $key => $val){
			if($name && is_numeric($key) )$key=$name;
			if(is_array($val)){

				if(isset($val[0])){
					$xml.=$this->arr2xml($val,$key);
				}
				else{
					$xml.='<'.$key.'>'."\n";
					$xml.=$this->arr2xml($val);
					$xml.='</'.$key.'>'."\n";
				}

			}
			else{
				if($name && is_numeric($key) )$key=$name;
				$tval= htmlspecialchars($val);
				if($tval!=$val)$xml.= '<'.$key.'><![CDATA['.$val.']]></'.$key.'>'."\n";
				else $xml.='<'.$key.'>'.$val.'</'.$key.'>'."\n";
			}
		}

		return $xml;
	}

	function save_xml($arrData,$strFilePath){
		$strData=$this->arr2xml($arrData);
		$strData = "<xml>\n".$strData."</xml>\n";
		file_put_contents($strFilePath,$strData);
	}

}// A2X END