import React, {useCallback} from 'react';
import HeaderLink from "./HeaderLink";
import Authed from "./Auth/Authed";
import Guest from "./Auth/Guest";
import {modals} from '../flags/Flags';
import {setFlag} from "../actions/Flags";
import SearchForm from "./SearchForm";
import {useDispatch, useMappedState} from 'redux-react-hook';
import {destroyAuth, getAuth} from "../actions/Auth";
import useAuth from "../hooks/useAuth";
import useModal from "../hooks/useModal";
import {APP_SETTINGS, USER_SETTINGS} from "../constants/Modals";
import useBind from "../hooks/useBind";
import Admin from "./Auth/Admin";

export default function Header() {
    const _destroyAuth = useBind(destroyAuth);
    const _getAuth = useBind(getAuth);

    const [openSettingsModal] = useModal(USER_SETTINGS);
    const [openAppSettings] = useModal(APP_SETTINGS);

    const auth = useAuth();

    async function handleDestroyAuth() {
        await _destroyAuth();
        getAuth();
    }

    return (
        <nav className="navbar-z flex flex-no-wrap flex-col md:flex-row items-stretch justify-center sticky border-b md:border-0 border-black pin-t pin-l pin-r bg-grey-darkest p-0">
            <a className="px-6 py-3 text-grey-lighter text-lg whitespace-no-wrap no-underline lg:w-1/5 mr-0" href="#">Servidores de_nerdTV</a>
            <SearchForm/>
            <ul className="hidden md:block navbar-nav flex-shrink">
                <li className="h-full flex justify-between items-stretch text-nowrap">
                    <Authed>
                        <Admin>
                            <HeaderLink
                                onClick={openAppSettings}
                                title="Configurações da Aplicação"
                                icon="settings"
                            />
                        </Admin>
                        <HeaderLink
                            onClick={openSettingsModal}
                            title="Configurações"
                            icon="settings"
                        />
                        <HeaderLink
                            onClick={handleDestroyAuth}
                            title="Logout"
                            icon="log-out"
                        />
                    </Authed>
                    <Guest>
                        <HeaderLink
                            href={auth?.redirect}
                            title="Login"
                            icon="log-in"
                        />
                    </Guest>
                </li>
            </ul>
        </nav>
    );
}