<?php

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150511085709 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql("
            DROP TABLE IF EXISTS `module_list`;

            CREATE TABLE IF NOT EXISTS `module_list` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `module_name` varchar(45) DEFAULT NULL,
            `module_desc` varchar(255) DEFAULT NULL,
            `module_route` varchar(45) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

            --
            -- Dumping data for table `module_list`
            --

            INSERT INTO `module_list` (`id`, `module_name`, `module_desc`, `module_route`) VALUES
            (1, 'LearnZF2Ajax', 'Learn Ajax with ZF2', 'learnZF2Ajax'),
            (2, 'LearnZF2FormUsage', 'Learn Form Usage with ZF2', 'learn-zf2-form-usage'),
            (3, 'LearnZF2Barcode', 'Learn Barcode Usage with ZF2', 'learn-zf2-barcode-usage'),
            (4, 'LearnZF2Pagination', 'Learn Pagination Usage with ZF2', 'learn-zf2-pagination'),
            (5, 'LearnZF2Log', 'Learn Log Usage with ZF2', 'learn-zf2-log'),
            (6, 'LearnZF2Navigation', 'Learn Navigation and menus with ZF2', 'learn-zf2-navigation'),
            (7, 'LearnZF2Acl', 'Learn ACL with ZF2', 'learn-zf2-acl'),
            (8, 'LearnZF2I18n', 'Learn Internationalization with ZF2', 'learn-zf2-i18n'),
            (9, 'LearnZF2Authentication', 'Learn Authentication with ZF2', 'learn-zf2-authentication');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("DROP TABLE IF EXISTS `module_list`");
    }
}
