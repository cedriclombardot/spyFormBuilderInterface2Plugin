<?php


/**
 * This class adds structure of 'spy_form_builder_fields' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/17/09 14:40:35
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.spyFormBuilderInterface2Plugin.lib.model.map
 */
class SpyFormBuilderFieldsMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.spyFormBuilderInterface2Plugin.lib.model.map.SpyFormBuilderFieldsMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(SpyFormBuilderFieldsPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(SpyFormBuilderFieldsPeer::TABLE_NAME);
		$tMap->setPhpName('SpyFormBuilderFields');
		$tMap->setClassname('SpyFormBuilderFields');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('WIDGET_TYPE', 'WidgetType', 'VARCHAR', true, 255);

		$tMap->addColumn('LABEL', 'Label', 'VARCHAR', false, 255);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', false, 255);

		$tMap->addColumn('HELP', 'Help', 'VARCHAR', false, 255);

		$tMap->addColumn('WIDGET_PARAMS', 'WidgetParams', 'LONGVARCHAR', false, null);

		$tMap->addColumn('HIDE_ON_EDIT', 'HideOnEdit', 'LONGVARCHAR', false, null);

		$tMap->addColumn('ONLY_FOR', 'OnlyFor', 'LONGVARCHAR', false, null);

		$tMap->addForeignKey('FORM_ID', 'FormId', 'INTEGER', 'spy_form_builder', 'ID', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('RANK', 'Rank', 'INTEGER', false, null);

	} // doBuild()

} // SpyFormBuilderFieldsMapBuilder
