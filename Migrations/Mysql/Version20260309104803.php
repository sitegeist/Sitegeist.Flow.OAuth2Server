<?php

declare(strict_types=1);

namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260309104803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE sitegeist_flow_oauth2server_accesstoken (persistence_object_identifier VARCHAR(40) NOT NULL, client VARCHAR(40) DEFAULT NULL, expirydatetime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', useridentifier VARCHAR(255) NOT NULL, isrevoked TINYINT(1) NOT NULL, INDEX IDX_F578739EC7440455 (client), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sitegeist_flow_oauth2server_infrastructure_ac_a3569_scopes_join (flow_infrastructure_accesstoken VARCHAR(40) NOT NULL, flow_infrastructure_scope VARCHAR(40) NOT NULL, INDEX IDX_F19BEF5964A8BBE0 (flow_infrastructure_accesstoken), INDEX IDX_F19BEF5922460A2 (flow_infrastructure_scope), PRIMARY KEY(flow_infrastructure_accesstoken, flow_infrastructure_scope)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sitegeist_flow_oauth2server_authcode (persistence_object_identifier VARCHAR(40) NOT NULL, client VARCHAR(40) DEFAULT NULL, redirecturi VARCHAR(255) DEFAULT NULL, expirydatetime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', useridentifier VARCHAR(255) NOT NULL, isrevoked TINYINT(1) NOT NULL, INDEX IDX_789936CDC7440455 (client), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sitegeist_flow_oauth2server_infrastructure_authcode_scopes_join (flow_infrastructure_authcode VARCHAR(40) NOT NULL, flow_infrastructure_scope VARCHAR(40) NOT NULL, INDEX IDX_CAB8403925FB8664 (flow_infrastructure_authcode), INDEX IDX_CAB8403922460A2 (flow_infrastructure_scope), PRIMARY KEY(flow_infrastructure_authcode, flow_infrastructure_scope)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sitegeist_flow_oauth2server_client (persistence_object_identifier VARCHAR(40) NOT NULL, secret VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, redirecturi LONGTEXT NOT NULL, identifier VARCHAR(255) NOT NULL, isconfidential TINYINT(1) NOT NULL, UNIQUE INDEX flow_identity_sitegeist_flow_oauth2server_client (identifier), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sitegeist_flow_oauth2server_refreshtoken (persistence_object_identifier VARCHAR(40) NOT NULL, accesstoken VARCHAR(40) DEFAULT NULL, client VARCHAR(40) DEFAULT NULL, expirydatetime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', useridentifier VARCHAR(255) NOT NULL, isrevoked TINYINT(1) NOT NULL, INDEX IDX_6D094B18F4CBB726 (accesstoken), INDEX IDX_6D094B18C7440455 (client), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sitegeist_flow_oauth2server_infrastructure_re_b9a09_scopes_join (flow_infrastructure_refreshtoken VARCHAR(40) NOT NULL, flow_infrastructure_scope VARCHAR(40) NOT NULL, INDEX IDX_782629EADA25C7EB (flow_infrastructure_refreshtoken), INDEX IDX_782629EA22460A2 (flow_infrastructure_scope), PRIMARY KEY(flow_infrastructure_refreshtoken, flow_infrastructure_scope)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sitegeist_flow_oauth2server_scope (persistence_object_identifier VARCHAR(40) NOT NULL, description LONGTEXT DEFAULT NULL, identifier VARCHAR(255) NOT NULL, UNIQUE INDEX flow_identity_sitegeist_flow_oauth2server_scope (identifier), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_accesstoken ADD CONSTRAINT FK_F578739EC7440455 FOREIGN KEY (client) REFERENCES sitegeist_flow_oauth2server_client (persistence_object_identifier)');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_ac_a3569_scopes_join ADD CONSTRAINT FK_F19BEF5964A8BBE0 FOREIGN KEY (flow_infrastructure_accesstoken) REFERENCES sitegeist_flow_oauth2server_accesstoken (persistence_object_identifier)');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_ac_a3569_scopes_join ADD CONSTRAINT FK_F19BEF5922460A2 FOREIGN KEY (flow_infrastructure_scope) REFERENCES sitegeist_flow_oauth2server_scope (persistence_object_identifier)');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_authcode ADD CONSTRAINT FK_789936CDC7440455 FOREIGN KEY (client) REFERENCES sitegeist_flow_oauth2server_client (persistence_object_identifier)');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_authcode_scopes_join ADD CONSTRAINT FK_CAB8403925FB8664 FOREIGN KEY (flow_infrastructure_authcode) REFERENCES sitegeist_flow_oauth2server_authcode (persistence_object_identifier)');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_authcode_scopes_join ADD CONSTRAINT FK_CAB8403922460A2 FOREIGN KEY (flow_infrastructure_scope) REFERENCES sitegeist_flow_oauth2server_scope (persistence_object_identifier)');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_refreshtoken ADD CONSTRAINT FK_6D094B18F4CBB726 FOREIGN KEY (accesstoken) REFERENCES sitegeist_flow_oauth2server_accesstoken (persistence_object_identifier)');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_refreshtoken ADD CONSTRAINT FK_6D094B18C7440455 FOREIGN KEY (client) REFERENCES sitegeist_flow_oauth2server_client (persistence_object_identifier)');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_re_b9a09_scopes_join ADD CONSTRAINT FK_782629EADA25C7EB FOREIGN KEY (flow_infrastructure_refreshtoken) REFERENCES sitegeist_flow_oauth2server_refreshtoken (persistence_object_identifier)');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_re_b9a09_scopes_join ADD CONSTRAINT FK_782629EA22460A2 FOREIGN KEY (flow_infrastructure_scope) REFERENCES sitegeist_flow_oauth2server_scope (persistence_object_identifier)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1027Platform'."
        );

        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_ac_a3569_scopes_join DROP FOREIGN KEY FK_F19BEF5964A8BBE0');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_refreshtoken DROP FOREIGN KEY FK_6D094B18F4CBB726');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_authcode_scopes_join DROP FOREIGN KEY FK_CAB8403925FB8664');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_accesstoken DROP FOREIGN KEY FK_F578739EC7440455');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_authcode DROP FOREIGN KEY FK_789936CDC7440455');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_refreshtoken DROP FOREIGN KEY FK_6D094B18C7440455');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_re_b9a09_scopes_join DROP FOREIGN KEY FK_782629EADA25C7EB');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_ac_a3569_scopes_join DROP FOREIGN KEY FK_F19BEF5922460A2');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_authcode_scopes_join DROP FOREIGN KEY FK_CAB8403922460A2');
        $this->addSql('ALTER TABLE sitegeist_flow_oauth2server_infrastructure_re_b9a09_scopes_join DROP FOREIGN KEY FK_782629EA22460A2');
        $this->addSql('DROP TABLE sitegeist_flow_oauth2server_accesstoken');
        $this->addSql('DROP TABLE sitegeist_flow_oauth2server_infrastructure_ac_a3569_scopes_join');
        $this->addSql('DROP TABLE sitegeist_flow_oauth2server_authcode');
        $this->addSql('DROP TABLE sitegeist_flow_oauth2server_infrastructure_authcode_scopes_join');
        $this->addSql('DROP TABLE sitegeist_flow_oauth2server_client');
        $this->addSql('DROP TABLE sitegeist_flow_oauth2server_refreshtoken');
        $this->addSql('DROP TABLE sitegeist_flow_oauth2server_infrastructure_re_b9a09_scopes_join');
        $this->addSql('DROP TABLE sitegeist_flow_oauth2server_scope');
    }
}
