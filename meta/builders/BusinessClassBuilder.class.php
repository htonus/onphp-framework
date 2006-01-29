<?php
/***************************************************************************
 *   Copyright (C) 2006 by Konstantin V. Arkhipov                          *
 *   voxus@onphp.org                                                       *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	final class BusinessClassBuilder extends BaseBuilder
	{
		public static function build(MetaClass $class)
		{
			$out = self::getHead();
			
			if ($type = $class->getType())
				$typeName = $type->toString().' ';
			else
				$typeName = null;
			
			if ($class->getPattern()->daoExist()) {
				$interfaces = ' implements DAOConnected';
				$dao = <<<EOT
		public static function dao()
		{
			return Singleton::getInstance('{$class->getName()}DAO');
		}

EOT;
			} else
				$dao = $interfaces = null;
			
			$out .= <<<EOT
	{$typeName}class {$class->getName()} extends Auto{$class->getName()}{$interfaces}
	{
EOT;

			if (!$type || $type->getId() !== MetaClassType::CLASS_ABSTRACT) {
				$out .= <<<EOT
			
		public static function create()
		{
			return new {$class->getName()}();
		}
		
{$dao}
EOT;
			}

			$out .= <<<EOT

		// your brilliant stuff goes here
	}

EOT;
			
			return $out.self::getHeel();
		}
		
		protected static function getHead()
		{
			$head = self::startCap();
			
			$head .=
				' *   This file will never be generated again -'
				.' feel free to edit.            *';

			return $head."\n".self::endCap();
		}
	}
?>