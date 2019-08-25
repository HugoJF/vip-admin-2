import React, {useState} from "react";
import AdminsTable from "./AdminsTable";
import useRouter from "../../hooks/useRouter";
import {Route} from "react-router-dom";
import {getAdmins} from "../../actions/Admins";
import useBind from "../../hooks/useBind";
import useAsyncEffect from "../../hooks/useAsyncEffect";
import useFastState from "../../hooks/useFastState";

export default function Admins() {
    const {match} = useRouter();

    const [loading, setLoading] = useState();
    const admins = useFastState('admins');
    const _getAdmins = useBind(getAdmins);

    useAsyncEffect(async () => {
        setLoading(true);
        await _getAdmins();
        setLoading(false);
    }, []);

    return <>
        <Route
            path={`${match.url}`}
            exact
            render={() => (
                <AdminsTable
                    loading={loading}
                    admins={Object.values(admins.byId)}
                />
            )}
        />
    </>
}