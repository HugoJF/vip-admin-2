import React, {useState, useEffect, useCallback} from 'react';
import TokensTable from "./TokensTable";
import Breadcrumb from "../Breadcrumb";
import {getTokens} from "../../actions/Tokens";
import {Route} from 'react-router-dom';
import TokenActivation from "./TokenActivation";
import useReactRouter from 'use-react-router';
import useFastState from "../../hooks/useFastState";
import useBind from "../../hooks/useBind";
import useAsyncEffect from "../../hooks/useAsyncEffect";

export default function Tokens() {
    const _getTokens = useBind(getTokens);
    const [loading, setLoading] = useState(false);

    const router = useReactRouter();
    const tokens = useFastState('tokens');

    useAsyncEffect(async () => {
        setLoading(true);
        await _getTokens();
        setLoading(false);
    }, []);
    let {match} = router;
    return (
        <>
            <Route
                path={`${match.url}`}
                exact
                render={() => (
                    <TokensTable
                        loading={loading}
                        tokens={Object.values(tokens.byId)}
                    />
                )}
            />
            <Route
                path={`${match.url}/:token`}
                exact
                render={({match}) => {
                    let token = tokens.byId[match.params.token];

                    if (token) {
                        return <Breadcrumb url={`${match.url}`} title={`Token #${token.id}`}>
                            <TokenActivation
                                token={token}
                            />
                        </Breadcrumb>;
                    } else {
                        return '';
                    }
                }}
            />
        </>
    );
}