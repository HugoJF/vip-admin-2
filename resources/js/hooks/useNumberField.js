import React from "react";
import {useField} from "react-final-form-hooks";
import useInputField from "./useInputField";

export default function useNumberField(name, form, props) {
    return useInputField('number', name, form, props);
}