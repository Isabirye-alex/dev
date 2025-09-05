<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="index.php" class="brand-link">
            <img src="assets/img/AdminLTELogo.png" alt="Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">E-Shop Dashboard</span>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item menu-open">
                    <a href="?page=index" class="nav-link active">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Products -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-bag"></i>
                        <p>
                            Products
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?page=all-products" class="nav-link">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>All Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=add-product" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Add Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=categories_view" class="nav-link">
                                <i class="nav-icon bi bi-grid-3x3-gap"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=brands" class="nav-link">
                                <i class="nav-icon bi bi-award"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=inventory" class="nav-link">
                                <i class="nav-icon bi bi-box-seam"></i>
                                <p>Inventory</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Orders -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-receipt"></i>
                        <p>
                            Orders
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?page=orders" class="nav-link">
                                <i class="nav-icon bi bi-list-check"></i>
                                <p>All Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=pending-orders" class="nav-link">
                                <i class="nav-icon bi bi-hourglass-split"></i>
                                <p>Pending Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=completed-orders" class="nav-link">
                                <i class="nav-icon bi bi-check-circle"></i>
                                <p>Completed Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=cancelled-orders" class="nav-link">
                                <i class="nav-icon bi bi-x-circle"></i>
                                <p>Cancelled Orders</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Customers -->
                <li class="nav-item">
                    <a href="?page=customers" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Customers</p>
                    </a>
                </li>

                <!-- Reports -->
                <li class="nav-item">
                    <a href="?page=reports" class="nav-link">
                        <i class="nav-icon bi bi-graph-up-arrow"></i>
                        <p>Reports</p>
                    </a>
                </li>

                <!-- Discounts / Coupons -->
                <li class="nav-item">
                    <a href="?page=discounts" class="nav-link">
                        <i class="nav-icon bi bi-tags"></i>
                        <p>Discounts</p>
                    </a>
                </li>

                <!-- Marketing -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-megaphone"></i>
                        <p>
                            Marketing
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?page=email-campaigns" class="nav-link">
                                <i class="nav-icon bi bi-envelope-paper"></i>
                                <p>Email Campaigns</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=promotions" class="nav-link">
                                <i class="nav-icon bi bi-stars"></i>
                                <p>Promotions</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a href="?page=settings" class="nav-link">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Settings</p>
                    </a>
                </li>

                <!-- System Management -->
                <li class="nav-header">System Management</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-layers"></i>
                        <p>
                            Manage Services
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?page=active-coupons" class="nav-link">
                                <i class="nav-icon bi bi-check2-square"></i>
                                <p>Active Coupons</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=expired-coupons" class="nav-link">
                                <i class="nav-icon bi bi-calendar-x"></i>
                                <p>Expired Coupons</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=used-coupons" class="nav-link">
                                <i class="nav-icon bi bi-recycle"></i>
                                <p>Used Coupons</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=generate-coupons" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle-dotted"></i>
                                <p>Generate Coupons</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Admin / Authentication -->
                <li class="nav-header">Admin</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-shield-lock"></i>
                        <p>
                            Users
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?page=system-users" class="nav-link">
                                <i class="nav-icon bi bi-person-lines-fill"></i>
                                <p>System Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=locked-users" class="nav-link">
                                <i class="nav-icon bi bi-lock"></i>
                                <p>Locked Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=active-users" class="nav-link">
                                <i class="nav-icon bi bi-person-check"></i>
                                <p>Active Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=system-roles-page" class="nav-link">
                                <i class="nav-icon bi bi-diagram-3"></i>
                                <p>User Roles</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Support -->
                <li class="nav-header">Support</li>
                <li class="nav-item">
                    <a href="?page=tickets" class="nav-link">
                        <i class="nav-icon bi bi-life-preserver"></i>
                        <p>Support Tickets</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=faqs" class="nav-link">
                        <i class="nav-icon bi bi-question-circle"></i>
                        <p>FAQs</p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="?page=logout" class="nav-link">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
