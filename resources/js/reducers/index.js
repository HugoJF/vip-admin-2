import {combineReducers} from "redux";
import auth              from "./auth";
import storage           from "redux-persist/lib/storage";
import {persistReducer}  from "redux-persist";
import tokens            from "./tokens";
import breadcrumbs       from "./breadcrumbs";
import orders            from "./orders";
import flags             from "./flags";
import search            from "./search";
import admins from "./admins";

const authConfig = {
    key: 'auth',
    whitelist: ['token'],
    storage,
};

const RootReducer = combineReducers({
    auth: persistReducer(authConfig, auth),
    search: search,
    flags: flags,
    admins: admins,
    tokens: tokens,
    breadcrumbs: breadcrumbs,
    orders: orders,
});

export default RootReducer