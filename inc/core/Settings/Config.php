<?php
return [
    'id' => 'settings',
    'folder' => 'core',
    'name' => 'Settings',
    'author' => 'Stackcode',
    'author_uri' => 'https://stackposts.com',
    'desc' => 'Configure your website',
    'icon' => 'fad fa-cog',
    'color' => '#ffc700',
    'role' => 1,
    'menu' => [
        'tab' => 5,
        'type' => 'bottom',
        'position' => 1010,
        'name' => 'Settings'
    ]
];

//https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=77ipg2pw5t3x3i&redirect_uri=http://localhost/Postglance/linkedin_profiles&state=34455709501&scope=r_basicprofile%20r_liteprofile%20w_member_social%20w_organization_social%20r_organization_social%20rw_organization_admin




//https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=77ipg2pw5t3x3i&redirect_uri=https://app2.postglance.com/linkedin_pages&state=8236286836&scope=r_basicprofile%20w_member_social%20w_organization_social%20r_organization_social%20rw_organization_admin


//return "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=". $this->app_id . "&redirect_uri=".$this->callback ."&state=". $this->csrf."&scope=r_ads_reporting r_ads rw_ads r_organization_admin r_basicprofile w_member_social w_organization_social r_organization_social rw_organization_admin"; 