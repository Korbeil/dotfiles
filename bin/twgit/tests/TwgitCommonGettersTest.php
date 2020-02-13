<?php

/**
 * @package Tests
 * @author Geoffroy Aubry <geoffroy.aubry@hi-media.com>
 * @author Geoffroy Letournel <gletournel@hi-media.com>
 */
class TwgitCommonGettersTest extends TwgitTestCase
{

    /**
     * @dataProvider providerTestGetDissidentRemoteBranches
     * @shcovers inc/common.inc.sh::get_dissident_remote_branches
     */
    public function testGetDissidentRemoteBranches ($sLocalCmd, $sExpectedResult)
    {
        $this->_remoteExec('git init && git commit --allow-empty -m "-" && git checkout -b feature-currentOfNonBareRepo');
        $this->_localExec(TWGIT_EXEC . ' init 1.2.3 ' . TWGIT_REPOSITORY_ORIGIN_DIR);
        $this->_localExec('cd ' . TWGIT_REPOSITORY_SECOND_REMOTE_DIR . ' && git init');
        $this->_localExec('git remote add second ' . TWGIT_REPOSITORY_SECOND_REMOTE_DIR);
        $this->_localExec('cd ' . TWGIT_REPOSITORY_THIRD_REMOTE_DIR . ' && git init');
        $this->_localExec('git remote add third ' . TWGIT_REPOSITORY_THIRD_REMOTE_DIR);

        $this->_localExec($sLocalCmd);
        $sMsg = $this->_localFunctionCall('get_dissident_remote_branches');
        $this->assertEquals($sExpectedResult, $sMsg);
    }

    public function providerTestGetDissidentRemoteBranches ()
    {
        return array(
            array(':', ''),
            array(
                'git checkout -b feature-X && git push ' . self::ORIGIN . ' feature-X'
                    . ' && git checkout -b release-X && git push ' . self::ORIGIN . ' release-X'
                    . ' && git checkout -b hotfix-X && git push ' . self::ORIGIN . ' hotfix-X'
                    . ' && git checkout -b demo-X && git push ' . self::ORIGIN . ' demo-X'
                    . ' && git checkout -b master && git push ' . self::ORIGIN . ' master'
                    . ' && git checkout -b outofprocess && git push ' . self::ORIGIN . ' outofprocess'
                    . ' && git remote set-head ' . self::ORIGIN . ' ' . self::STABLE,
                self::_remote('outofprocess')
            ),
            array(
                'git checkout -b outofprocess && git push ' . self::ORIGIN . ' outofprocess && git push second outofprocess'
                    . ' && git checkout -b out2 && git push ' . self::ORIGIN . ' out2 && git push second out2',
                self::_remote('out2') . "\n" . self::_remote('outofprocess')
            ),
            array(
                'git checkout -b outofprocess && git push ' . self::ORIGIN . ' outofprocess && git push second outofprocess'
                    . ' && git checkout -b out2 && git push ' . self::ORIGIN . ' out2 && git push third out2',
                self::_remote('out2') . "\n" . self::_remote('outofprocess')
            ),
        );
    }

    /**
     * @shcovers inc/common.inc.sh::getFeatureSubject
     */
    public function testGetFeatureSubject_WithNoParameter ()
    {
        $sCmd = 'TWGIT_FEATURES_SUBJECT_PATH="$(mktemp ' . TWGIT_TMP_DIR . '/XXXXXXXXXX)"; '
              . 'echo \'2;The subject of 2\' > \$TWGIT_FEATURES_SUBJECT_PATH; '
              . 'config_file=\'F\'; TWGIT_FEATURE_SUBJECT_CONNECTOR=\'github\'; '
              . 'getFeatureSubject; '
              . 'rm -f "\$TWGIT_FEATURES_SUBJECT_PATH"';
        $sMsg = $this->_localShellCodeCall($sCmd);
        $this->assertEmpty($sMsg);
    }

    /**
     * @shcovers inc/common.inc.sh::getFeatureSubject
     */
    public function testGetFeatureSubject_WithParameterButNoSubjectNorConnector ()
    {
        $sCmd = 'TWGIT_FEATURES_SUBJECT_PATH="$(mktemp ' . TWGIT_TMP_DIR . '/XXXXXXXXXX)"; '
              . 'config_file=\'F\'; TWGIT_FEATURE_SUBJECT_CONNECTOR=\'no_connector\'; '
              . 'getFeatureSubject 2; '
              . 'rm -f "\$TWGIT_FEATURES_SUBJECT_PATH"';
        $sMsg = $this->_localShellCodeCall($sCmd);
        $this->assertEmpty($sMsg);
    }

    /**
     * @shcovers inc/common.inc.sh::getFeatureSubject
     */
    public function testGetFeatureSubject_WithParameterAndSubject ()
    {
        $sCmd = 'TWGIT_FEATURES_SUBJECT_PATH="$(mktemp ' . TWGIT_TMP_DIR . '/XXXXXXXXXX)"; '
              . 'echo \'2;The subject of 2\' > \$TWGIT_FEATURES_SUBJECT_PATH; '
              . 'config_file=\'F\'; TWGIT_FEATURE_SUBJECT_CONNECTOR=\'no_connector\'; '
              . 'getFeatureSubject 2; '
              . 'rm -f "\$TWGIT_FEATURES_SUBJECT_PATH"';
        $sMsg = $this->_localShellCodeCall($sCmd);
        $this->assertEquals('The subject of 2', $sMsg);
    }

    /**
     * @shcovers inc/common.inc.sh::getFeatureSubject
     */
//     public function testGetFeatureSubject_WithParameterAndConnector ()
//     {
//         $sCmd = 'TWGIT_FEATURES_SUBJECT_PATH="$(mktemp ' . TWGIT_TMP_DIR . '/XXXXXXXXXX)"; '
//               . 'config_file=\'F\'; TWGIT_FEATURE_SUBJECT_CONNECTOR=\'github\'; '
//               . 'getFeatureSubject 2; '
//               . 'rm -f "\$TWGIT_FEATURES_SUBJECT_PATH"';
//         $sMsg = $this->_localShellCodeCall($sCmd);
//         $this->assertEquals('email when too old features', $sMsg);
//     }
// => Pb with API rate limit: http://developer.github.com/v3/#rate-limiting

    /**
     * @shcovers inc/common.inc.sh::displayFeatureSubject
     */
    public function testDisplayFeatureSubject_WithKnownFeature ()
    {
        $sCmd = 'function getFeatureSubject() { echo "XYZ-\$1";}; '
              . 'displayFeatureSubject 2';
        $sMsg = $this->_localShellCodeCall($sCmd);
        $this->assertEquals('XYZ-2', $sMsg);
    }

    /**
     * @shcovers inc/common.inc.sh::displayFeatureSubject
     */
    public function testDisplayFeatureSubject_WithUnknownFeature ()
    {
        $sCmd = 'function getFeatureSubject() { echo ;}; '
              . 'displayFeatureSubject 2 \"default subject\"';
        $sMsg = $this->_localShellCodeCall($sCmd);
        $this->assertEquals('default subject', $sMsg);
    }
}
