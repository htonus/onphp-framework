<?php
/***************************************************************************
 *   Copyright (C) 2004-2006 by Konstantin V. Arkhipov                     *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * @ingroup OSQL
	**/
	final class DeleteQuery extends QuerySkeleton implements SQLTableName
	{
		private $table	= null;
		
		public function getId()
		{
			throw new UnsupportedMethodException();
		}

		/**
		 * @return DeleteQuery
		 */
		public function from($table)
		{
			$this->table = $table;
			
			return $this;
		}
		
		public function getTable()
		{
			return $this->table;
		}
		
		public function toDialectString(Dialect $dialect)
		{
			if (count($this->where) > 0)
				return
					"DELETE FROM {$dialect->quoteTable($this->table)} "
					.parent::toDialectString($dialect);
			else
				throw new WrongArgumentException(
					"leave '{$this->table}' table alone in peace, bastard"
				);
		}
	}
?>