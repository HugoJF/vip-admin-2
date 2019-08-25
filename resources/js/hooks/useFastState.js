import {useCallback} from "react";
import {useMappedState} from "redux-react-hook";

export default function useFastState(key) {
    const mapState = useCallback(
        state => ({
            value: state[key],
        }), []
    );

    const {value} = useMappedState(mapState);

    return value;
}