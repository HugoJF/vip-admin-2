import React, {useCallback} from 'react';
import Home from "./Home";
import DashboardContainer from "../DashboardContainer";
import Tokens from "./Tokens";
import Login from "../Login";
import Orders from "./Orders";
import Breadcrumb from "../Breadcrumb";
import {ToastContainer} from "react-toastify";
import Authed from "../Auth/Authed";
import UserSettingsEditionModal from "../modal/UserSettingsEditionModal";
import Search from "./Search";
import {Route} from 'react-router-dom';
import useModal from "../../hooks/useModal";
import {APP_SETTINGS, DASHBOARD_HELP, ORDERS_HELP, SETTINGS_HELP, TOKENS_HELP, USER_SETTINGS} from "../../constants/Modals";
import AppSettingsModal from "../modal/AppSettingsModal";
import DashboardHelp from "../modal/DashboardHelp";
import OrdersHelp from "../modal/OrdersHelp";
import TokensHelp from "../modal/TokensHelp";
import SettingsHelp from "../modal/SettingsHelp";
import Admin from "../Auth/Admin";
import useRoutes from "../../hooks/useRoutes";
import Admins from "./Admins";

export default function Root() {
    const routes = useRoutes();

    const [, , userSettingsModalOpen] = useModal(USER_SETTINGS);
    const [, , appSettingsModalOpen] = useModal(APP_SETTINGS);

    const [, , dashboardHelpModalOpen] = useModal(DASHBOARD_HELP);
    const [, , ordersHelpModalOpen] = useModal(ORDERS_HELP);
    const [, , tokensHelpModalOpen] = useModal(TOKENS_HELP);
    const [, , settingsHelpModalOpen] = useModal(SETTINGS_HELP);

    return (
        <DashboardContainer>
            <ToastContainer/>
            {/* Auth only modals */}
            <Authed>
                <UserSettingsEditionModal open={userSettingsModalOpen}/>
            </Authed>

            {/* Admin only modals */}
            <Admin>
                <AppSettingsModal open={appSettingsModalOpen}/>
            </Admin>

            {/* Generic modals */}
            <DashboardHelp open={dashboardHelpModalOpen}/>
            <OrdersHelp open={ordersHelpModalOpen}/>
            <TokensHelp open={tokensHelpModalOpen}/>
            <SettingsHelp open={settingsHelpModalOpen}/>

            {/* Authed routes */}
            <Authed>
                {/* Home */}
                <Route
                    path={routes.home.raw()}
                    exact
                    render={() => (
                        <Home/>
                    )}
                />

                {/* Search results */}
                <Route
                    path={routes.search.raw()}
                    render={({match}) => (
                        <Breadcrumb title="Search" url={match.url}>
                            <Breadcrumb title={match.params.term} url={match.url}>
                                <Search term={match.params.term}/>
                            </Breadcrumb>
                        </Breadcrumb>
                    )}
                />

                {/* Tokens  */}
                <Route
                    path={routes.tokens.index.raw()}
                    render={({match}) => (
                        <Breadcrumb title="Tokens" url={match.url}>
                            <Tokens/>
                        </Breadcrumb>
                    )}
                />

                {/* Orders */}
                <Route
                    path={routes.orders.index.raw()}
                    render={({match}) => (
                        <Breadcrumb title="Orders" url={match.url}>
                            <Orders/>
                        </Breadcrumb>
                    )}
                />

                {/* Custom Admins */}
                <Route
                    path={routes.admins.index.raw()}
                    render={({match}) => (
                        <Breadcrumb title="Admins" url={match.url}>
                            <Admins/>
                        </Breadcrumb>
                    )}
                />
            </Authed>

            {/* Login handler */}
            <Route
                path={routes.login.raw()}
                render={() => (
                    <Login/>
                )}
            />
        </DashboardContainer>
    );
}