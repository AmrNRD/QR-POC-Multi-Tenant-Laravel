<?php


namespace App\Domain\Company\jobs;


use App\Domain\Admin\Entities\Admin;
use App\Domain\Admin\Repositories\Contracts\AdminRepository;
use App\Domain\Company\Entities\Company;
use App\Domain\Tenant\User\Entities\User;
use App\Domain\Tenant\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\TenancyModels\Hostname;
use App\Infrastructure\TenancyModels\Website;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateTenantJob implements ShouldQueue
{
    use Dispatchable,SerializesModels, InteractsWithQueue, Queueable;

    /**
     * @var Company
     */
    protected Company $company;

    /**
     * @var Admin
     */
    protected Admin $admin;

    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * Create a new job instance.
     *
     * @param Company $company
     * @param Admin $admin
     * @param UserRepository $userRepository
     */
    public function __construct(Company $company,Admin $admin,UserRepository $userRepository)
    {
        $this->company=$company;
        $this->admin=$admin;
        $this->userRepository=$userRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $website = $this->registerTenant($this->admin,$this->company);
        $this->createAdminTenantAccount($this->admin, $website);
    }

    /**
     * @param int $admin_id
     * @param int $company_id
     * @return Website
     */
    private function createWebsite(int $admin_id,int $company_id): Website
    {
        $website = new Website;
        app(WebsiteRepository::class)->create($website);
        $website->admin_id = $admin_id;
        $website->company_id = $company_id;
        $website->save();
        return $website;
    }

    /**
     * @param string $company_name
     * @param Website $website
     * @return Hostname
     */
    private function createHostname(string $company_name,Website $website): Hostname
    {
        $hostname = new Hostname();
        $baseUrl = env('APP_BASE_URL');
        $hostname->fqdn = "{$company_name}.{$baseUrl}";
        $hostname->id = (string)Str::uuid();
        app(HostnameRepository::class)->attach($hostname, $website);
        $hostname->website_id = $website->id;
        $hostname->save();
        return $hostname;
    }


    /**
     * @param Admin $admin
     * @param Website $website
     * @return User
     */
    private function createAdminTenantAccount(Admin $admin,Website $website):User
    {
        app(Environment::class)->tenant($website);
        return $this->userRepository->create(['name' => $admin->name, 'email' => $admin->email, 'password' => $admin->password]);
    }


    /**
     * @param Admin $admin
     * @param Company $company
     * @return Website
     */
    private function registerTenant(Admin $admin,Company $company):Website
    {
        $website = $this->createWebsite($admin->id,$company->id);
        $hostname = $this->createHostname($company->name,$website);
        return $website;
    }

}
