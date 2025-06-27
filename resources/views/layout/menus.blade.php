 <!-- Sidebar -->
 <div class="sidebar" id="sidebar">
     <!-- Logo -->
     <div class="sidebar-logo">
         <a href="#" class="logo logo-normal">
             <img src="{{ URL::asset('') }}assets/img/logo.svg" alt="Logo">
         </a>
         <a href="#" class="logo-small">
             <img src="{{ URL::asset('') }}assets/img/logo-small.svg" alt="Logo">
         </a>
         <a href="#" class="dark-logo">
             <img src="{{ URL::asset('') }}assets/img/logo-white.svg" alt="Logo">
         </a>
     </div>
     <!-- /Logo -->
     <div class="modern-profile p-3 pb-0">
         <div class="text-center rounded bg-light p-3 mb-4 user-profile">
             <div class="avatar avatar-lg online mb-3">
                 <img src="{{ URL::asset('') }}assets/img/profiles/avatar-02.jpg" alt="Img"
                     class="img-fluid rounded-circle">
             </div>
             <h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
             <p class="fs-10">System Admin</p>
         </div>
         <div class="sidebar-nav mb-3">
             <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
                 <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
                 <li class="nav-item"><a class="nav-link border-0" href="#">Chats</a></li>
                 <li class="nav-item"><a class="nav-link border-0" href="#">Inbox</a></li>
             </ul>
         </div>
     </div>
     <div class="sidebar-header p-3 pb-0 pt-2">
         <div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
             <div class="avatar avatar-md onlin">
                 <img src="{{ URL::asset('') }}assets/img/profiles/avatar-02.jpg" alt="Img"
                     class="img-fluid rounded-circle">
             </div>
             <div class="text-start sidebar-profile-info ms-2">
                 <h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
                 <p class="fs-10">System Admin</p>
             </div>
         </div>
         <div class="input-group input-group-flat d-inline-flex mb-4">
             <span class="input-icon-addon">
                 <i class="ti ti-search"></i>
             </span>
             <input type="text" class="form-control" placeholder="Search in HRMS">
             <span class="input-group-text">
                 <kbd>CTRL + / </kbd>
             </span>
         </div>
         <div class="d-flex align-items-center justify-content-between menu-item mb-3">
             <div class="me-3">
                 <a href="calendar" class="btn btn-menubar">
                     <i class="ti ti-layout-grid-remove"></i>
                 </a>
             </div>
             <div class="me-3">
                 <a href="{{ url('chat') }}" class="btn btn-menubar position-relative">
                     <i class="ti ti-brand-hipchat"></i>
                     <span
                         class="badge bg-info rounded-pill d-flex align-items-center justify-content-center header-badge">5</span>
                 </a>
             </div>
             <div class="me-3 notification-item">
                 <a href="{{ url('activity') }}" class="btn btn-menubar position-relative me-1">
                     <i class="ti ti-bell"></i>
                     <span class="notification-status-dot"></span>
                 </a>
             </div>
             <div class="me-0">
                 <a href="{{ url('email') }}" class="btn btn-menubar">
                     <i class="ti ti-message"></i>
                 </a>
             </div>
         </div>
     </div>
     <div class="sidebar-inner slimscroll">
         <div id="sidebar-menu" class="sidebar-menu">
             <ul>
                 <li class="menu-title"><span>MAIN MENU</span></li>
                 <li>
                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('admin-dashboard') ? 'active subdrop' : '' }}
                                 {{ Request::is('employee-dashboard') ? 'active subdrop' : '' }}
                                 {{ Request::is('index') ? 'active subdrop' : '' }}
                                  {{ Request::is('deals-dashboard') ? 'active subdrop' : '' }}
                                   {{ Request::is('leads-dashboard') ? 'active subdrop' : '' }}">
                                 <i class="ti ti-smart-home"></i>
                                 <span>Tableau de bord</span>
                                 {{-- <span class="badge badge-danger fs-10 fw-medium text-white p-1">Hot</span> --}}
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li>
                                     <a href="{{ url('admin-dashboard') }}"
                                         class="{{ Request::is('admin-dashboard') ? 'active' : '' }}{{ Request::is('index') ? 'active' : '' }}">Admin</a>
                                 </li>
                                 <li>
                                     <a href="{{ url('employee-dashboard') }}"
                                         class="{{ Request::is('employee-dashboard') ? 'active' : '' }}{{ Request::is('index') ? 'active' : '' }}">Employé</a>
                                 </li>
                             </ul>
                         </li>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="
                                   {{ Request::is('calendar') ? 'active subdrop' : '' }}
                                    ">
                                 <i class="ti ti-layout-grid-add"></i><span>Applications</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li><a href="{{ url('calendar') }}"
                                         class="{{ Request::is('calendar') ? 'active' : '' }}">Calendar</a>
                                 </li>
                             </ul>
                         </li>
                     </ul>
                 </li>
                 {{-- <li class="menu-title"><span>PROJECTS</span></li>
                <li>
                    <ul>
                        <li>
                            <a href="clients-grid">
                                <i class="ti ti-users-group"></i><span>Clients</span>
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-box"></i><span>Projects</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="projects-grid">Projects</a></li>
                                <li><a href="tasks">Tasks</a></li>
                                <li><a href="task-board">Task Board</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}
                 <li class="menu-title"><span>CRM</span></li>
                 <li>
                     <ul>
                         <li class="{{ Request::is('activity') ? 'active' : '' }}">
                             <a href="{{ url('activity') }}">
                                 <i class="ti ti-activity"></i><span>Pist d'audit</span>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="menu-title"><span>HRM</span></li>
                 <li>
                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('employees') ? 'active subdrop' : '' }}
                                 {{ Request::is('departments') ? 'active subdrop' : '' }}
                                  {{ Request::is('designations') ? 'active subdrop' : '' }}
                                   {{ Request::is('policy') ? 'active subdrop' : '' }}">
                                 <i class="ti ti-users"></i><span>Employés</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li><a class="{{ Request::is('employees') ? 'active' : '' }}"
                                         href="employees">Employés</a></li>
                                 <li><a class="{{ Request::is('departments') ? 'active' : '' }}"
                                         href="departments">Départements</a></li>
                                 <li><a class="{{ Request::is('designations') ? 'active' : '' }}"
                                         href="designations">Désignations</a></li>
                                 <li><a class="{{ Request::is('policy') ? 'active' : '' }}"
                                         href="policy">Politiques</a></li>
                             </ul>
                         </li>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('tickets') ? 'active subdrop' : '' }}">
                                 <i class="ti ti-ticket"></i><span>Tickets</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li><a class="{{ Request::is('tickets') ? 'active' : '' }}"
                                         href="tickets">Tickets</a></li>
                             </ul>
                         </li>
                         <li class="{{ Request::is('holidays') ? 'active' : '' }}">
                             <a href="holidays">
                                 <i class="ti ti-calendar-event"></i><span>Fériés</span>
                             </a>
                         </li>
                         <li class="submenu">
                             <a href="javascript:void(0);">
                                 <i class="ti ti-file-time"></i><span>Présences</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li class="submenu submenu-two">
                                     <a href="javascript:void(0);">Leaves<span
                                             class="menu-arrow inside-submenu"></span></a>
                                     <ul>
                                         <li><a href="leaves">Leaves (Admin)</a></li>
                                         <li><a href="leaves-employee">Leave (Employee)</a></li>
                                         <li><a href="leave-settings">Leave Settings</a></li>
                                     </ul>
                                 </li>
                                 <li><a href="attendance-admin">Attendance (Admin)</a></li>
                                 <li><a href="attendance-employee">Attendance (Employee)</a></li>
                                 <li><a href="timesheets">Timesheets</a></li>
                                 <li><a href="schedule-timing">Shift & Schedule</a></li>
                                 <li><a href="overtime">Overtime</a></li>
                             </ul>
                         </li>
                         <li class="submenu">
                             <a href="javascript:void(0);" class="">
                                 <i class="ti ti-school"></i><span>Performance</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li><a href="performance-indicator">Performance Indicator</a></li>
                                 <li><a href="performance-review">Performance Review</a></li>
                                 <li><a href="performance-appraisal">Performance Appraisal</a></li>
                                 <li><a href="goal-tracking">Goal List</a></li>
                                 <li><a href="goal-type">Goal Type</a></li>
                             </ul>
                         </li>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('training') ? 'active subdrop' : '' }}
                                 {{ Request::is('trainers') ? 'active subdrop' : '' }}
                                  {{ Request::is('training-type') ? 'active subdrop' : '' }}">
                                 <i class="ti ti-edit"></i><span>Formation</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li><a href="training"
                                         class="{{ Request::is('training') ? 'active' : '' }}">Formation</a></li>
                                 <li><a href="trainers"
                                         class="{{ Request::is('trainers') ? 'active' : '' }}">Formateurs</a></li>
                                 <li><a href="training-type"
                                         class="{{ Request::is('training-type') ? 'active' : '' }}">Type formation</a>
                                 </li>
                             </ul>
                         </li>
                         <li class="{{ Request::is('promotion') ? 'active' : '' }}">
                             <a href="promotion">
                                 <i class="ti ti-speakerphone"></i><span>Promotion</span>
                             </a>
                         </li>
                         <li class="{{ Request::is('resignation') ? 'active' : '' }}">
                             <a href="resignation">
                                 <i class="ti ti-external-link"></i><span>Démission</span>
                             </a>
                         </li>
                         <li class="{{ Request::is('termination') ? 'active' : '' }}">
                             <a href="termination">
                                 <i class="ti ti-circle-x"></i><span>Fin de contrat</span>
                             </a>
                         </li>
                     </ul>
                 </li>
                 {{-- <li class="menu-title"><span>FINANCE & ACCOUNTS</span></li>
                <li>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-shopping-cart-dollar"></i><span>Sales</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="estimates">Estimates</a></li>
                                <li><a href="invoices">Invoices</a></li>
                                <li><a href="payments">Payments</a></li>
                                <li><a href="expenses">Expenses</a></li>
                                <li><a href="provident-fund">Provident Fund</a></li>
                                <li><a href="taxes">Taxes</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-file-dollar"></i><span>Accounting</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="categories">Categories</a></li>
                                <li><a href="budgets">Budgets</a></li>
                                <li><a href="budget-expenses">Budget Expenses</a></li>
                                <li><a href="budget-revenues">Budget Revenues</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-cash"></i><span>Payroll</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="employee-salary">Employee Salary</a></li>
                                <li><a href="payslip">Payslip</a></li>
                                <li><a href="payroll">Payroll Items</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}
                 <li class="menu-title"><span>ADMINISTRATION</span></li>
                 <li>
                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('assetes') ? 'active subdrop' : '' }}
                                 {{ Request::is('asset-categories') ? 'active subdrop' : '' }}">
                                 <i class="ti ti-cash"></i><span>Assets</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li>
                                     <a href="{{ url('assetes') }}"
                                         class="{{ Request::is('assetes') ? 'active' : '' }}">Assets</a>
                                 </li>
                                 <li>
                                     <a href="{{ url('asset-categories') }}"
                                         class="{{ Request::is('asset-categories') ? 'active' : '' }}">Asset
                                         Categories</a>
                                 </li>
                             </ul>
                         </li>
                         {{-- <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('knowledgebase') ? 'active subdrop' : '' }}
                                 {{ Request::is('activity') ? 'active subdrop' : '' }}
                                  ">
                                 <i class="ti ti-headset"></i><span>Help & Supports</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li><a href="{{ url('knowledgebase') }}"
                                         class="{{ Request::is('knowledgebase') ? 'active' : '' }}">Knowledge
                                         Base</a></li>
                                 <li><a href="{{ url('activity') }}"
                                         class="{{ Request::is('activity') ? 'active' : '' }}">Activities</a>
                                 </li>
                             </ul>
                         </li> --}}
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('users') ? 'active subdrop' : '' }}
                                 {{ Request::is('roles-permissions') ? 'active subdrop' : '' }}">
                                 <i class="ti ti-user-star"></i><span>User Management</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li><a href="{{ url('users') }}"
                                         class="{{ Request::is('users') ? 'active' : '' }}">Users</a></li>
                                 <li><a href="{{ url('roles-permissions') }}"
                                         class="{{ Request::is('roles-permissions') ? 'active' : '' }}">Roles &
                                         Permissions</a></li>
                             </ul>
                         </li>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('attendance-report') ? 'active subdrop' : '' }}
                                 {{ Request::is('daily-report') ? 'active subdrop' : '' }}
                                  {{ Request::is('leave-report') ? 'active subdrop' : '' }}
                                  {{ Request::is('employee-report') ? 'active subdrop' : '' }}
                                    ">
                                 <i class="ti ti-user-star"></i><span>Reports</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li><a href="{{ url('employee-report') }}"
                                         class="{{ Request::is('employee-report') ? 'active' : '' }}">Rapport
                                         d'employés</a></li>
                                 <li><a href="{{ url('attendance-report') }}"
                                         class="{{ Request::is('attendance-report') ? 'active' : '' }}">Rapport de
                                         présences</a></li>
                                 <li><a href="{{ url('leave-report') }}"
                                         class="{{ Request::is('leave-report') ? 'active' : '' }}">Rapport de
                                         congés</a></li>
                                 <li><a href="{{ url('daily-report') }}"
                                         class="{{ Request::is('daily-report') ? 'active' : '' }}">Rapport
                                         quotidien</a></li>
                             </ul>
                         </li>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('clear-cache') ? 'active subdrop' : '' }}
                                 {{ Request::is('profile-settings') ? 'active subdrop' : '' }}
                                  {{ Request::is('security-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('notification-settings') ? 'active subdrop' : '' }}
                                    {{ Request::is('connected-apps') ? 'active subdrop' : '' }}
                                     {{ Request::is('bussiness-settings') ? 'active subdrop' : '' }}
                                 {{ Request::is('seo-settings') ? 'active subdrop' : '' }}
                                  {{ Request::is('localization-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('prefixes') ? 'active subdrop' : '' }}
                                   {{ Request::is('preferences') ? 'active subdrop' : '' }}
                                   {{ Request::is('performance-appraisal') ? 'active subdrop' : '' }}
                                   {{ Request::is('language') ? 'active subdrop' : '' }}
                                   {{ Request::is('authentication-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('ai-settings') ? 'active subdrop' : '' }}
                                    {{ Request::is('salary-settings') ? 'active subdrop' : '' }}
                                 {{ Request::is('approval-settings') ? 'active subdrop' : '' }}
                                  {{ Request::is('invoice-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('leave-type') ? 'active subdrop' : '' }}
                                   {{ Request::is('custom-fields') ? 'active subdrop' : '' }}
                                    {{ Request::is('email-settings') ? 'active subdrop' : '' }}
                                 {{ Request::is('email-template') ? 'active subdrop' : '' }}
                                  {{ Request::is('sms-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('sms-template') ? 'active subdrop' : '' }}
                                   {{ Request::is('otp-settings') ? 'active subdrop' : '' }}
                                    {{ Request::is('payment-gateways') ? 'active subdrop' : '' }}
                                 {{ Request::is('tax-rates') ? 'active subdrop' : '' }}
                                  {{ Request::is('currencies') ? 'active subdrop' : '' }}
                                  {{ Request::is('job-category') ? 'active subdrop' : '' }}
                                  {{ Request::is('job-type') ? 'active subdrop' : '' }}
                                  {{ Request::is('job-level') ? 'active subdrop' : '' }}
                                  {{ Request::is('job-experience') ? 'active subdrop' : '' }}
                                  {{ Request::is('job-qualification') ? 'active subdrop' : '' }}
                                     ">
                                 <i class="ti ti-settings"></i><span>Settings</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li class="submenu submenu-two">
                                     <a href="javascript:void(0);"
                                         class="{{ Request::is('job-category') ? 'active subdrop' : '' }}
                                  {{ Request::is('job-type') ? 'active subdrop' : '' }}
                                  {{ Request::is('job-level') ? 'active subdrop' : '' }}
                                  {{ Request::is('job-experience') ? 'active subdrop' : '' }}
                                  {{ Request::is('job-qualification') ? 'active subdrop' : '' }}
                                    ">Jobs
                                         Settings<span class="menu-arrow inside-submenu"></span></a>
                                     <ul>
                                         <li><a href="{{ url('job-category') }}"
                                                 class="{{ Request::is('job-category') ? 'active' : '' }}">Job
                                                 Category</a>
                                         </li>
                                         <li><a href="{{ url('job-type') }}"
                                                 class="{{ Request::is('job-type') ? 'active' : '' }}">Job Type</a>
                                         </li>
                                         <li><a href="{{ url('job-level') }}"
                                                 class="{{ Request::is('job-level') ? 'active' : '' }}">Job Level</a>
                                         </li>
                                         <li><a href="{{ url('job-experience') }}"
                                                 class="{{ Request::is('job-experience') ? 'active' : '' }}">Job
                                                 Experience</a></li>
                                         <li><a href="{{ url('job-qualification') }}"
                                                 class="{{ Request::is('job-qualification') ? 'active' : '' }}">Job
                                                 Qualification</a></li>
                                     </ul>
                                 </li>
                                 <li class="submenu submenu-two">
                                     <a href="javascript:void(0);"
                                         class="{{ Request::is('profile-settings') ? 'active subdrop' : '' }}
                                 {{ Request::is('security-settings') ? 'active subdrop' : '' }}
                                  {{ Request::is('notification-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('connected-apps') ? 'active subdrop' : '' }}
                                    ">General
                                         Settings<span class="menu-arrow inside-submenu"></span></a>
                                     <ul>
                                         <li><a href="{{ url('profile-settings') }}"
                                                 class="{{ Request::is('profile-settings') ? 'active' : '' }}">Profile</a>
                                         </li>
                                         <li><a href="{{ url('security-settings') }}"
                                                 class="{{ Request::is('security-settings') ? 'active' : '' }}">Security</a>
                                         </li>
                                         <li><a href="{{ url('notification-settings') }}"
                                                 class="{{ Request::is('notification-settings') ? 'active' : '' }}">Notifications</a>
                                         </li>
                                         <li><a href="{{ url('connected-apps') }}"
                                                 class="{{ Request::is('connected-apps') ? 'active' : '' }}">Connected
                                                 Apps</a></li>
                                     </ul>
                                 </li>
                                 <li class="submenu submenu-two">
                                     <a href="javascript:void(0);"
                                         class="{{ Request::is('bussiness-settings') ? 'active subdrop' : '' }}
                                 {{ Request::is('seo-settings') ? 'active subdrop' : '' }}
                                  {{ Request::is('localization-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('prefixes') ? 'active subdrop' : '' }}
                                   {{ Request::is('preferences') ? 'active subdrop' : '' }}
                                   {{ Request::is('performance-appraisal') ? 'active subdrop' : '' }}
                                   {{ Request::is('language') ? 'active subdrop' : '' }}
                                   {{ Request::is('authentication-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('ai-settings') ? 'active subdrop' : '' }}
                                    ">Website
                                         Settings<span class="menu-arrow inside-submenu"></span></a>
                                     <ul>
                                         <li><a href="{{ url('bussiness-settings') }}"
                                                 class="{{ Request::is('bussiness-settings') ? 'active' : '' }}">Business
                                                 Settings</a></li>
                                         <li><a href="{{ url('seo-settings') }}"
                                                 class="{{ Request::is('seo-settings') ? 'active' : '' }}">SEO
                                                 Settings</a></li>
                                         <li><a href="{{ url('localization-settings') }}"
                                                 class="{{ Request::is('localization-settings') ? 'active' : '' }}">Localization</a>
                                         </li>
                                         <li><a href="{{ url('prefixes') }}"
                                                 class="{{ Request::is('prefixes') ? 'active' : '' }}">Prefixes</a>
                                         </li>
                                         <li><a href="{{ url('preferences') }}"
                                                 class="{{ Request::is('preferences') ? 'active' : '' }}">Preferences</a>
                                         </li>
                                         <li><a href="{{ url('performance-appraisal') }}"
                                                 class="{{ Request::is('performance-appraisal') ? 'active' : '' }}">Appearance</a>
                                         </li>
                                         <li><a href="{{ url('language') }}"
                                                 class="{{ Request::is('language') ? 'active' : '' }}">Language</a>
                                         </li>
                                         <li><a href="{{ url('authentication-settings') }}"
                                                 class="{{ Request::is('authentication-settings') ? 'active' : '' }}">Authentication</a>
                                         </li>
                                         <li><a href="{{ url('ai-settings') }}"
                                                 class="{{ Request::is('ai-settings') ? 'active' : '' }}">AI
                                                 Settings</a></li>
                                     </ul>
                                 </li>
                                 <li class="submenu submenu-two">
                                     <a href="javascript:void(0);"
                                         class="{{ Request::is('salary-settings') ? 'active subdrop' : '' }}
                                 {{ Request::is('approval-settings') ? 'active subdrop' : '' }}
                                  {{ Request::is('invoice-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('leave-type') ? 'active subdrop' : '' }}
                                   {{ Request::is('custom-fields') ? 'active subdrop' : '' }}
                                    ">App
                                         Settings<span class="menu-arrow inside-submenu"></span></a>
                                     <ul>
                                         <li><a href="{{ url('salary-settings') }}"
                                                 class="{{ Request::is('salary-settings') ? 'active' : '' }}">Salary
                                                 Settings</a></li>
                                         <li><a href="{{ url('approval-settings') }}"
                                                 class="{{ Request::is('approval-settings') ? 'active' : '' }}">Approval
                                                 Settings</a></li>
                                         <li><a href="{{ url('invoice-settings') }}"
                                                 class="{{ Request::is('invoice-settings') ? 'active' : '' }}">Invoice
                                                 Settings</a></li>
                                         <li><a href="{{ url('leave-type') }}"
                                                 class="{{ Request::is('leave-type') ? 'active' : '' }}">Leave
                                                 Type</a></li>
                                         <li><a href="{{ url('custom-fields') }}"
                                                 class="{{ Request::is('custom-fields') ? 'active' : '' }}">Custom
                                                 Fields</a></li>
                                     </ul>
                                 </li>
                                 <li class="submenu submenu-two">
                                     <a href="javascript:void(0);"
                                         class="{{ Request::is('email-settings') ? 'active subdrop' : '' }}
                                 {{ Request::is('email-template') ? 'active subdrop' : '' }}
                                  {{ Request::is('sms-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('sms-template') ? 'active subdrop' : '' }}
                                   {{ Request::is('otp-settings') ? 'active subdrop' : '' }}
                                    ">System
                                         Settings<span class="menu-arrow inside-submenu"></span></a>
                                     <ul>
                                         <li><a href="{{ url('email-settings') }}"
                                                 class="{{ Request::is('email-settings') ? 'active' : '' }}">Email
                                                 Settings</a></li>
                                         <li><a href="{{ url('email-template') }}"
                                                 class="{{ Request::is('email-template') ? 'active' : '' }}">Email
                                                 Templates</a></li>
                                         <li><a href="{{ url('sms-settings') }}"
                                                 class="{{ Request::is('sms-settings') ? 'active' : '' }}">SMS
                                                 Settings</a></li>
                                         <li><a href="{{ url('sms-template') }}"
                                                 class="{{ Request::is('sms-template') ? 'active' : '' }}">SMS
                                                 Templates</a></li>
                                         <li><a href="{{ url('otp-settings') }}"
                                                 class="{{ Request::is('otp-settings') ? 'active' : '' }}">OTP</a>
                                         </li>
                                     </ul>
                                 </li>
                                 <li class="submenu submenu-two">
                                     <a href="javascript:void(0);"
                                         class="{{ Request::is('payment-gateways') ? 'active subdrop' : '' }}
                                 {{ Request::is('tax-rates') ? 'active subdrop' : '' }}
                                  {{ Request::is('currencies') ? 'active subdrop' : '' }}
                                    ">Financial
                                         Settings<span class="menu-arrow inside-submenu"></span></a>
                                     <ul>
                                         <li><a href="{{ url('payment-gateways') }}"
                                                 class="{{ Request::is('payment-gateways') ? 'active' : '' }}">Payment
                                                 Gateways</a></li>
                                         <li><a href="{{ url('tax-rates') }}"
                                                 class="{{ Request::is('tax-rates') ? 'active' : '' }}">Tax
                                                 Rate</a></li>
                                         <li><a href="{{ url('currencies') }}"
                                                 class="{{ Request::is('currencies') ? 'active' : '' }}">Currencies</a>
                                         </li>
                                     </ul>
                                 </li>
                                 <li class="submenu submenu-two">
                                     <a href="javascript:void(0);"
                                         class="{{ Request::is('clear-cache') ? 'active subdrop' : '' }}">Other
                                         Settings<span class="menu-arrow inside-submenu"></span></a>
                                     <ul>
                                         <li><a href="{{ url('clear-cache') }}"
                                                 class="{{ Request::is('clear-cache') ? 'active' : '' }}">Clear
                                                 Cache</a></li>
                                     </ul>
                                 </li>
                             </ul>
                         </li>
                     </ul>
                 </li>
             </ul>
         </div>
     </div>
 </div>
 <!-- /Sidebar -->
