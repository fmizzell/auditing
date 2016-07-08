<?php
namespace Fmizzell\Auditing\Drupal6;
use Fmizzell\Auditing\Report;

class User extends Report
{
    public function generateReport()
    {
        // Total number of users.
        $query = \Database::getConnection('default', 'legacy')->select('users', 'u');
        $query->fields('u', array('uid'));
        $count = $query->countQuery();
        $total_users = $count->execute()->fetchCol()[0];

        $title = "Users";
        $report = "# {$title}" . PHP_EOL;
        $this->addMenuItem($title);

        $report .= "| Total |" . PHP_EOL;
        $report .= "|-------|" . PHP_EOL;
        $report .= "| {$total_users} |" . PHP_EOL;

        $query = \Database::getConnection('default', 'legacy')->select('role', 'r');
        $query->fields('r', array('rid', 'name'));
        $results = $query->execute();

        $title = "Roles";
        $report .= "# {$title}" . PHP_EOL;
        $this->addMenuItem($title);

        $report .= "| Roles | Number of Users |" . PHP_EOL;
        $report .= "|-------|-----------------|" . PHP_EOL;

        foreach ($results as $result) {
            // Number of users per role.
            $query = \Database::getConnection('default', 'legacy')->select('users', 'u');
            $query->join('users_roles', 'ur', "u.uid = ur.uid");
            $query->condition('ur.rid', $result->rid);
            $count = $query->countQuery();
            $num_users = $count->execute()->fetchCol()[0];

            $report .= "| {$result->name} | {$num_users} |" . PHP_EOL;
        }

        $this->saveReport("user", $report);
    }
}