import React, {} from 'react';
import SidebarItem from "./SidebarItem";
import SidebarLink from "./SidebarLink";
import useModal from "../hooks/useModal";
import useAuth from "../hooks/useAuth";
import {APP_SETTINGS, DASHBOARD_HELP, ORDERS_HELP, SETTINGS_HELP, TOKENS_HELP, USER_SETTINGS} from "../constants/Modals";
import Admin from "./Auth/Admin";

export default function Sidebar() {
    const [openUserSettings] = useModal(USER_SETTINGS);

    const [openDashboardHelp] = useModal(DASHBOARD_HELP);
    const [openOrdersHelp] = useModal(ORDERS_HELP);
    const [openTokensHelp] = useModal(TOKENS_HELP);
    const [openSettingsHelp] = useModal(SETTINGS_HELP);

    const auth = useAuth();

    function openSettingsModal() {
        openUserSettings();
    }

    return (
        <nav className="xl:w-1/5 light xl:sidebar bg-black">
            <div className="flex flex-col md:flex-row xl:flex-col sidebar-sticky p-4 xl:pt-16">
                <div className="hidden p-2 w-full md:w-1/5 xl:w-full self-center md:flex flex-col mt-4 mb-4 items-center">
                    <div className="self-center p-4 pin-t justify-center items-center bg-white rounded-full shadow-md sm:flex">
                        <img className="w-28 rounded-full" src={auth?.user?.avatar}/>
                    </div>
                    <p className="px-2 py-1 mt-3 font-semibold text-grey-light">{auth?.user?.username}</p>
                </div>
                <div className="w-full md:w-2/5 pr-0 md:pr-8 xl:pr-0 xl:w-full">
                    <h6 className="flex justify-between items-center pr-3 mt-8 mb-4 uppercase font-normal tracking-wide text-grey-darker">
                        <span>Menu</span>
                        <span className="ml-4 mt-px flex-grow border-b border-dashed border-grey-darkest"/>
                    </h6>
                    <ul className="pl-0 mb-0 flex flex-col list-reset text-sm">

                        <SidebarItem
                            icon="home"
                            title="Dashboard"
                            to="/"
                            onHelpClick={openDashboardHelp}
                        />

                        <SidebarItem
                            icon="credit-card"
                            title="Pedidos"
                            to="/orders"
                            onHelpClick={openOrdersHelp}
                        />

                        <SidebarItem
                            icon="link"
                            title="Tokens"
                            to="/tokens"
                            onHelpClick={openTokensHelp}
                        />

                        <SidebarItem
                            icon="settings"
                            title="Configurações"
                            onClick={openSettingsModal}
                            onHelpClick={openSettingsHelp}
                        />

                        <Admin>
                            <SidebarItem
                                icon="briefcase"
                                title="Admins"
                                to="/admins"
                            />
                        </Admin>

                    </ul>
                </div>
                <div className="w-full md:w-2/5 xl:w-full">
                    <h6 className="flex justify-between items-center pr-3 mt-8 mb-4 uppercase font-normal tracking-wide text-grey-darker">
                        <span>Links rápidos</span>
                        <span className="ml-4 mt-px flex-grow border-b border-dashed border-grey-darkest"/>
                    </h6>

                    <ul className="pl-0 mb-0 flex flex-col list-reset text-sm">
                        <SidebarLink
                            href="https://denerdtv.com/como-comprar-vip-com-itens/"
                            title="Como comprar VIP com skins"
                            current
                        />
                        <SidebarLink
                            title="Como comprar VIP com MercadoPago"
                        />
                        <SidebarLink
                            title="Como comprar VIP com PayPal"
                        />
                        <SidebarLink
                            href="https://denerdtv.com/faq/"
                            title="Perguntas frequentes"
                        />
                        <SidebarLink
                            href="https://denerdtv.com/discord"
                            title="Suporte"
                        />
                    </ul>
                </div>
            </div>
        </nav>
    );
}