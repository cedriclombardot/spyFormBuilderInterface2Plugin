<?php


/**
 * This class adds structure of 'spy_form_builder_validators' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 11/25/09 19:18:55
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.spyFormBuilderInterface2Plugin.lib.model.map
 */
class SpyFormBuilderValidatorsMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.spyFormBuilderInterface2Plugin.lib.model.map.SpyFormBuilderValidatorsMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(SpyFormBuilderValidatorsPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(SpyFormBuilderValidatorsPeer::TABLE_NAME);
		$tMap->setPhpName('SpyFormBuilderValidators');
		$tMap->setClassname('SpyFormBuilderValidators');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('VALIDATOR_TYPE', 'ValidatorType', 'VARCHAR', true, 255);

		$tMap->addForeignKey('FIELD_ID', 'FieldId', 'INTEGER', 'spy_form_builder_fields', 'ID', true, null);

		$tMap->addColumn('VALIDATOR_PARAMS', 'ValidatorParams', 'LONGVARCHAR', false, null);

		$tMap->addColumn('INVALID_MSG', 'InvalidMsg', 'LONGVARCHAR', false, null);

		$tMap->addColumn('RANK', 'Rank', 'INTEGER', true, null);

	} // doBuild()

} // SpyFormBuilderValidatorsMapBuilder
