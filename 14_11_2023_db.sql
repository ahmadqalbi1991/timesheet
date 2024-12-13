--
-- PostgreSQL database dump
--

-- Dumped from database version 12.17 (Ubuntu 12.17-1.pgdg20.04+1)
-- Dumped by pg_dump version 15.5 (Ubuntu 15.5-1.pgdg20.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

ALTER TABLE ONLY public.warehousing_details DROP CONSTRAINT warehousing_details_booking_id_foreign;
ALTER TABLE ONLY public.users DROP CONSTRAINT users_role_id_foreign;
ALTER TABLE ONLY public.user_wallets DROP CONSTRAINT user_wallets_user_id_foreign;
ALTER TABLE ONLY public.driver_details DROP CONSTRAINT driver_details_user_id_foreign;
ALTER TABLE ONLY public.driver_details DROP CONSTRAINT driver_details_truck_type_id_foreign;
ALTER TABLE ONLY public.deligate_attributes DROP CONSTRAINT deligate_attributes_deligate_id_foreign;
ALTER TABLE ONLY public.bookings DROP CONSTRAINT bookings_sender_id_foreign;
ALTER TABLE ONLY public.booking_trucks DROP CONSTRAINT booking_trucks_booking_id_foreign;
ALTER TABLE ONLY public.booking_reviews DROP CONSTRAINT booking_reviews_booking_id_foreign;
ALTER TABLE ONLY public.booking_qoutes DROP CONSTRAINT booking_qoutes_driver_id_foreign;
ALTER TABLE ONLY public.booking_qoutes DROP CONSTRAINT booking_qoutes_booking_id_foreign;
ALTER TABLE ONLY public.booking_deligate_details DROP CONSTRAINT booking_deligate_details_booking_id_foreign;
ALTER TABLE ONLY public.booking_containers DROP CONSTRAINT booking_containers_booking_id_foreign;
ALTER TABLE ONLY public.accepted_qoutes DROP CONSTRAINT accepted_qoutes_driver_id_foreign;
ALTER TABLE ONLY public.accepted_qoutes DROP CONSTRAINT accepted_qoutes_booking_id_foreign;
DROP INDEX public.user_password_resets_email_index;
DROP INDEX public.personal_access_tokens_tokenable_type_tokenable_id_index;
DROP INDEX public.password_resets_email_index;
ALTER TABLE ONLY public.warehousing_details DROP CONSTRAINT warehousing_details_pkey;
ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
ALTER TABLE ONLY public.user_wallets DROP CONSTRAINT user_wallets_pkey;
ALTER TABLE ONLY public.user_wallet_transactions DROP CONSTRAINT user_wallet_transactions_pkey;
ALTER TABLE ONLY public.user_password_resets DROP CONSTRAINT user_password_resets_pkey;
ALTER TABLE ONLY public.truck_types DROP CONSTRAINT truck_types_pkey;
ALTER TABLE ONLY public.temp_users DROP CONSTRAINT temp_users_pkey;
ALTER TABLE ONLY public.temp_users DROP CONSTRAINT temp_users_phone_unique;
ALTER TABLE ONLY public.temp_users DROP CONSTRAINT temp_users_email_unique;
ALTER TABLE ONLY public.temp_users DROP CONSTRAINT temp_users_driving_license_number_unique;
ALTER TABLE ONLY public.storage_types DROP CONSTRAINT storage_types_pkey;
ALTER TABLE ONLY public.shipping_methods DROP CONSTRAINT shipping_methods_pkey;
ALTER TABLE ONLY public.settings DROP CONSTRAINT settings_pkey;
ALTER TABLE ONLY public.roles DROP CONSTRAINT roles_pkey;
ALTER TABLE ONLY public.role_permissions DROP CONSTRAINT role_permissions_pkey;
ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_token_unique;
ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_pkey;
ALTER TABLE ONLY public.pages DROP CONSTRAINT pages_pkey;
ALTER TABLE ONLY public.notifications DROP CONSTRAINT notifications_pkey;
ALTER TABLE ONLY public.notification_users DROP CONSTRAINT notification_users_pkey;
ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
ALTER TABLE ONLY public.languages DROP CONSTRAINT languages_pkey;
ALTER TABLE ONLY public.help_request DROP CONSTRAINT help_request_pkey;
ALTER TABLE ONLY public.faq DROP CONSTRAINT faq_pkey;
ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_uuid_unique;
ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_pkey;
ALTER TABLE ONLY public.driver_details DROP CONSTRAINT driver_details_pkey;
ALTER TABLE ONLY public.deligates DROP CONSTRAINT deligates_pkey;
ALTER TABLE ONLY public.deligate_attributes DROP CONSTRAINT deligate_attributes_pkey;
ALTER TABLE ONLY public.country_languages DROP CONSTRAINT country_languages_pkey;
ALTER TABLE ONLY public.countries DROP CONSTRAINT countries_pkey;
ALTER TABLE ONLY public.containers DROP CONSTRAINT containers_pkey;
ALTER TABLE ONLY public.companies DROP CONSTRAINT companies_pkey;
ALTER TABLE ONLY public.cities DROP CONSTRAINT cities_pkey;
ALTER TABLE ONLY public.cart_warehousing_details DROP CONSTRAINT cart_warehousing_details_pkey;
ALTER TABLE ONLY public.cart_deligate_details DROP CONSTRAINT cart_deligate_details_pkey;
ALTER TABLE ONLY public.bookings DROP CONSTRAINT bookings_pkey;
ALTER TABLE ONLY public.booking_trucks DROP CONSTRAINT booking_trucks_pkey;
ALTER TABLE ONLY public.booking_truck_carts DROP CONSTRAINT booking_truck_carts_pkey;
ALTER TABLE ONLY public.booking_truck_alots DROP CONSTRAINT booking_truck_alots_pkey;
ALTER TABLE ONLY public.booking_status_trackings DROP CONSTRAINT booking_status_trackings_pkey;
ALTER TABLE ONLY public.booking_reviews DROP CONSTRAINT booking_reviews_pkey;
ALTER TABLE ONLY public.booking_qoutes DROP CONSTRAINT booking_qoutes_pkey;
ALTER TABLE ONLY public.booking_deligate_details DROP CONSTRAINT booking_deligate_details_pkey;
ALTER TABLE ONLY public.booking_containers DROP CONSTRAINT booking_containers_pkey;
ALTER TABLE ONLY public.booking_carts DROP CONSTRAINT booking_carts_pkey;
ALTER TABLE ONLY public.booking_additional_charges DROP CONSTRAINT booking_additional_charges_pkey;
ALTER TABLE ONLY public.blacklists DROP CONSTRAINT blacklists_pkey;
ALTER TABLE ONLY public.app_settings DROP CONSTRAINT app_settings_pkey;
ALTER TABLE ONLY public.addresses DROP CONSTRAINT addresses_pkey;
ALTER TABLE ONLY public.accepted_qoutes DROP CONSTRAINT accepted_qoutes_pkey;
ALTER TABLE public.warehousing_details ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.user_wallets ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.user_wallet_transactions ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.user_password_resets ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.truck_types ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.temp_users ALTER COLUMN temp_user_id DROP DEFAULT;
ALTER TABLE public.storage_types ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.shipping_methods ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.settings ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.roles ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.role_permissions ALTER COLUMN permission_id DROP DEFAULT;
ALTER TABLE public.personal_access_tokens ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.pages ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.notifications ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.notification_users ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.languages ALTER COLUMN language_id DROP DEFAULT;
ALTER TABLE public.help_request ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.faq ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.failed_jobs ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.driver_details ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.deligates ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.deligate_attributes ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.country_languages ALTER COLUMN country_lang_id DROP DEFAULT;
ALTER TABLE public.countries ALTER COLUMN country_id DROP DEFAULT;
ALTER TABLE public.containers ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.companies ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.cities ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.cart_warehousing_details ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.cart_deligate_details ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.bookings ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.booking_trucks ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.booking_truck_carts ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.booking_truck_alots ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.booking_status_trackings ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.booking_reviews ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.booking_qoutes ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.booking_deligate_details ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.booking_containers ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.booking_carts ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.booking_additional_charges ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.blacklists ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.app_settings ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.addresses ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.accepted_qoutes ALTER COLUMN id DROP DEFAULT;
DROP SEQUENCE public.warehousing_details_id_seq;
DROP TABLE public.warehousing_details;
DROP SEQUENCE public.users_id_seq;
DROP TABLE public.users;
DROP SEQUENCE public.user_wallets_id_seq;
DROP TABLE public.user_wallets;
DROP SEQUENCE public.user_wallet_transactions_id_seq;
DROP TABLE public.user_wallet_transactions;
DROP SEQUENCE public.user_password_resets_id_seq;
DROP TABLE public.user_password_resets;
DROP SEQUENCE public.truck_types_id_seq;
DROP TABLE public.truck_types;
DROP SEQUENCE public.temp_users_temp_user_id_seq;
DROP TABLE public.temp_users;
DROP SEQUENCE public.storage_types_id_seq;
DROP TABLE public.storage_types;
DROP SEQUENCE public.shipping_methods_id_seq;
DROP TABLE public.shipping_methods;
DROP SEQUENCE public.settings_id_seq;
DROP TABLE public.settings;
DROP SEQUENCE public.roles_id_seq;
DROP TABLE public.roles;
DROP SEQUENCE public.role_permissions_permission_id_seq;
DROP TABLE public.role_permissions;
DROP SEQUENCE public.personal_access_tokens_id_seq;
DROP TABLE public.personal_access_tokens;
DROP TABLE public.password_resets;
DROP SEQUENCE public.pages_id_seq;
DROP TABLE public.pages;
DROP SEQUENCE public.notifications_id_seq;
DROP TABLE public.notifications;
DROP SEQUENCE public.notification_users_id_seq;
DROP TABLE public.notification_users;
DROP SEQUENCE public.migrations_id_seq;
DROP TABLE public.migrations;
DROP SEQUENCE public.languages_language_id_seq;
DROP TABLE public.languages;
DROP SEQUENCE public.help_request_id_seq;
DROP TABLE public.help_request;
DROP SEQUENCE public.faq_id_seq;
DROP TABLE public.faq;
DROP SEQUENCE public.failed_jobs_id_seq;
DROP TABLE public.failed_jobs;
DROP TABLE public.driver_types;
DROP SEQUENCE public.driver_details_id_seq;
DROP TABLE public.driver_details;
DROP SEQUENCE public.deligates_id_seq;
DROP TABLE public.deligates;
DROP SEQUENCE public.deligate_attributes_id_seq;
DROP TABLE public.deligate_attributes;
DROP SEQUENCE public.country_languages_country_lang_id_seq;
DROP TABLE public.country_languages;
DROP SEQUENCE public.countries_country_id_seq;
DROP TABLE public.countries;
DROP SEQUENCE public.containers_id_seq;
DROP TABLE public.containers;
DROP SEQUENCE public.companies_id_seq;
DROP TABLE public.companies;
DROP SEQUENCE public.cities_id_seq;
DROP TABLE public.cities;
DROP SEQUENCE public.cart_warehousing_details_id_seq;
DROP TABLE public.cart_warehousing_details;
DROP SEQUENCE public.cart_deligate_details_id_seq;
DROP TABLE public.cart_deligate_details;
DROP SEQUENCE public.bookings_id_seq;
DROP TABLE public.bookings;
DROP SEQUENCE public.booking_trucks_id_seq;
DROP TABLE public.booking_trucks;
DROP SEQUENCE public.booking_truck_carts_id_seq;
DROP TABLE public.booking_truck_carts;
DROP SEQUENCE public.booking_truck_alots_id_seq;
DROP TABLE public.booking_truck_alots;
DROP SEQUENCE public.booking_status_trackings_id_seq;
DROP TABLE public.booking_status_trackings;
DROP SEQUENCE public.booking_reviews_id_seq;
DROP TABLE public.booking_reviews;
DROP SEQUENCE public.booking_qoutes_id_seq;
DROP TABLE public.booking_qoutes;
DROP SEQUENCE public.booking_deligate_details_id_seq;
DROP TABLE public.booking_deligate_details;
DROP SEQUENCE public.booking_containers_id_seq;
DROP TABLE public.booking_containers;
DROP SEQUENCE public.booking_carts_id_seq;
DROP TABLE public.booking_carts;
DROP SEQUENCE public.booking_additional_charges_id_seq;
DROP TABLE public.booking_additional_charges;
DROP SEQUENCE public.blacklists_id_seq;
DROP TABLE public.blacklists;
DROP SEQUENCE public.app_settings_id_seq;
DROP TABLE public.app_settings;
DROP SEQUENCE public.addresses_id_seq;
DROP TABLE public.addresses;
DROP SEQUENCE public.accepted_qoutes_id_seq;
DROP TABLE public.accepted_qoutes;
DROP EXTENSION postgis;
-- *not* dropping schema, since initdb creates it
--
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

-- *not* creating schema, since initdb creates it


ALTER SCHEMA public OWNER TO postgres;

--
-- Name: postgis; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;


--
-- Name: EXTENSION postgis; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis IS 'PostGIS geometry and geography spatial types and functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: accepted_qoutes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.accepted_qoutes (
    id bigint NOT NULL,
    booking_id integer NOT NULL,
    driver_id integer NOT NULL,
    hours integer NOT NULL,
    qouted_amount double precision,
    commission_amount double precision,
    border_charges double precision,
    shipping_charges double precision,
    wating_charges double precision,
    custom_charges double precision,
    cost_of_truck double precision,
    received_amount double precision,
    total_amount double precision,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    booking_truck_id integer,
    delivery_note text,
    customer_signature text,
    statuscode integer DEFAULT 0 NOT NULL,
    CONSTRAINT accepted_qoutes_status_check CHECK (((status)::text = ANY (ARRAY[('pending'::character varying)::text, ('qouted'::character varying)::text, ('accepted'::character varying)::text, ('journey_started'::character varying)::text, ('item_collected'::character varying)::text, ('on_the_way'::character varying)::text, ('border_crossing'::character varying)::text, ('custom_clearance'::character varying)::text, ('delivered'::character varying)::text])))
);


ALTER TABLE public.accepted_qoutes OWNER TO postgres;

--
-- Name: accepted_qoutes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.accepted_qoutes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.accepted_qoutes_id_seq OWNER TO postgres;

--
-- Name: accepted_qoutes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.accepted_qoutes_id_seq OWNED BY public.accepted_qoutes.id;


--
-- Name: addresses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.addresses (
    id bigint NOT NULL,
    user_id integer,
    address text,
    latitude character varying(255),
    longitude character varying(255),
    city_id integer,
    country_id integer,
    zip_code character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    is_deleted integer DEFAULT 0 NOT NULL,
    dial_code integer,
    phone character varying(255),
    building character varying(255)
);


ALTER TABLE public.addresses OWNER TO postgres;

--
-- Name: addresses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.addresses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.addresses_id_seq OWNER TO postgres;

--
-- Name: addresses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.addresses_id_seq OWNED BY public.addresses.id;


--
-- Name: app_settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.app_settings (
    id bigint NOT NULL,
    email character varying(255),
    website character varying(255),
    contact_numbers text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.app_settings OWNER TO postgres;

--
-- Name: app_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.app_settings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.app_settings_id_seq OWNER TO postgres;

--
-- Name: app_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.app_settings_id_seq OWNED BY public.app_settings.id;


--
-- Name: blacklists; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.blacklists (
    id bigint NOT NULL,
    user_id integer,
    user_device_id character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.blacklists OWNER TO postgres;

--
-- Name: blacklists_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.blacklists_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.blacklists_id_seq OWNER TO postgres;

--
-- Name: blacklists_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.blacklists_id_seq OWNED BY public.blacklists.id;


--
-- Name: booking_additional_charges; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_additional_charges (
    id bigint NOT NULL,
    booking_id integer NOT NULL,
    charges_name character varying(255) NOT NULL,
    charges_amount double precision DEFAULT '0'::double precision NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.booking_additional_charges OWNER TO postgres;

--
-- Name: booking_additional_charges_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_additional_charges_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_additional_charges_id_seq OWNER TO postgres;

--
-- Name: booking_additional_charges_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_additional_charges_id_seq OWNED BY public.booking_additional_charges.id;


--
-- Name: booking_carts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_carts (
    id bigint NOT NULL,
    is_collection integer,
    collection_address integer,
    deliver_address integer,
    sender_id bigint,
    deligate_id bigint,
    deligate_type character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    device_cart_id character varying(255),
    booking_number character varying(255),
    parent_id character varying(255) DEFAULT '0'::character varying NOT NULL
);


ALTER TABLE public.booking_carts OWNER TO postgres;

--
-- Name: booking_carts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_carts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_carts_id_seq OWNER TO postgres;

--
-- Name: booking_carts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_carts_id_seq OWNED BY public.booking_carts.id;


--
-- Name: booking_containers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_containers (
    id bigint NOT NULL,
    booking_id integer NOT NULL,
    container_id integer NOT NULL,
    quantity integer NOT NULL,
    gross_weight double precision NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.booking_containers OWNER TO postgres;

--
-- Name: booking_containers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_containers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_containers_id_seq OWNER TO postgres;

--
-- Name: booking_containers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_containers_id_seq OWNED BY public.booking_containers.id;


--
-- Name: booking_deligate_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_deligate_details (
    id bigint NOT NULL,
    item character varying(255),
    booking_id integer,
    no_of_packages integer,
    dimension_of_each_package character varying(255),
    weight_of_each_package character varying(255),
    total_gross_weight integer,
    total_volume_in_cbm character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.booking_deligate_details OWNER TO postgres;

--
-- Name: booking_deligate_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_deligate_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_deligate_details_id_seq OWNER TO postgres;

--
-- Name: booking_deligate_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_deligate_details_id_seq OWNED BY public.booking_deligate_details.id;


--
-- Name: booking_qoutes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_qoutes (
    id bigint NOT NULL,
    booking_id bigint NOT NULL,
    driver_id bigint NOT NULL,
    price integer NOT NULL,
    hours integer NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    comission_amount double precision DEFAULT '0'::double precision NOT NULL,
    is_admin_approved character varying(255) DEFAULT 'no'::character varying NOT NULL,
    booking_truck_id integer,
    qouted_at timestamp(0) without time zone,
    statuscode integer DEFAULT 0 NOT NULL,
    CONSTRAINT booking_qoutes_is_admin_approved_check CHECK (((is_admin_approved)::text = ANY (ARRAY[('no'::character varying)::text, ('yes'::character varying)::text]))),
    CONSTRAINT booking_qoutes_status_check CHECK (((status)::text = ANY (ARRAY[('pending'::character varying)::text, ('qouted'::character varying)::text, ('accepted'::character varying)::text, ('rejected'::character varying)::text])))
);


ALTER TABLE public.booking_qoutes OWNER TO postgres;

--
-- Name: booking_qoutes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_qoutes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_qoutes_id_seq OWNER TO postgres;

--
-- Name: booking_qoutes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_qoutes_id_seq OWNED BY public.booking_qoutes.id;


--
-- Name: booking_reviews; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_reviews (
    id bigint NOT NULL,
    booking_id bigint,
    customer_id bigint,
    rate double precision DEFAULT '0'::double precision NOT NULL,
    comment text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    updated_by integer,
    CONSTRAINT booking_reviews_status_check CHECK (((status)::text = ANY (ARRAY[('pending'::character varying)::text, ('approve'::character varying)::text, ('disapprove'::character varying)::text])))
);


ALTER TABLE public.booking_reviews OWNER TO postgres;

--
-- Name: booking_reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_reviews_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_reviews_id_seq OWNER TO postgres;

--
-- Name: booking_reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_reviews_id_seq OWNED BY public.booking_reviews.id;


--
-- Name: booking_status_trackings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_status_trackings (
    id bigint NOT NULL,
    booking_id integer NOT NULL,
    status_tracking character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    driver_id integer,
    statuscode integer DEFAULT 0 NOT NULL,
    quote_id integer DEFAULT 0 NOT NULL,
    CONSTRAINT booking_status_trackings_status_tracking_check CHECK (((status_tracking)::text = ANY (ARRAY[('request_created'::character varying)::text, ('accepted'::character varying)::text, ('journey_started'::character varying)::text, ('item_collected'::character varying)::text, ('on_the_way'::character varying)::text, ('border_crossing'::character varying)::text, ('custom_clearance'::character varying)::text, ('delivered'::character varying)::text])))
);


ALTER TABLE public.booking_status_trackings OWNER TO postgres;

--
-- Name: booking_status_trackings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_status_trackings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_status_trackings_id_seq OWNER TO postgres;

--
-- Name: booking_status_trackings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_status_trackings_id_seq OWNED BY public.booking_status_trackings.id;


--
-- Name: booking_truck_alots; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_truck_alots (
    id bigint NOT NULL,
    booking_truck_id integer,
    user_id integer,
    role_id integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.booking_truck_alots OWNER TO postgres;

--
-- Name: booking_truck_alots_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_truck_alots_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_truck_alots_id_seq OWNER TO postgres;

--
-- Name: booking_truck_alots_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_truck_alots_id_seq OWNED BY public.booking_truck_alots.id;


--
-- Name: booking_truck_carts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_truck_carts (
    id bigint NOT NULL,
    booking_cart_id integer NOT NULL,
    truck_id integer NOT NULL,
    quantity integer NOT NULL,
    gross_weight character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.booking_truck_carts OWNER TO postgres;

--
-- Name: booking_truck_carts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_truck_carts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_truck_carts_id_seq OWNER TO postgres;

--
-- Name: booking_truck_carts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_truck_carts_id_seq OWNED BY public.booking_truck_carts.id;


--
-- Name: booking_trucks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_trucks (
    id bigint NOT NULL,
    booking_id integer NOT NULL,
    truck_id integer NOT NULL,
    quantity integer NOT NULL,
    gross_weight character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.booking_trucks OWNER TO postgres;

--
-- Name: booking_trucks_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_trucks_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_trucks_id_seq OWNER TO postgres;

--
-- Name: booking_trucks_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_trucks_id_seq OWNED BY public.booking_trucks.id;


--
-- Name: bookings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bookings (
    id bigint NOT NULL,
    is_collection integer,
    collection_address text,
    deliver_address text,
    sender_id bigint,
    deligate_id bigint,
    deligate_type character varying(255),
    admin_response character varying(255) NOT NULL,
    comission_amount integer,
    customer_signature character varying(255) DEFAULT '0'::character varying,
    delivery_note text,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    booking_number character varying(255),
    is_paid character varying(255) DEFAULT 'no'::character varying NOT NULL,
    invoice_number character varying(255),
    total_commission_amount double precision,
    total_received_amount double precision DEFAULT '0'::double precision NOT NULL,
    sub_total double precision,
    grand_total double precision,
    shipping_method_id integer,
    total_qoutation_amount double precision DEFAULT '0'::double precision NOT NULL,
    collection_latitude character varying(255),
    collection_longitude character varying(255),
    collection_country character varying(255),
    collection_city character varying(255),
    collection_zipcode character varying(255),
    deliver_latitude character varying(255),
    deliver_longitude character varying(255),
    deliver_country character varying(255),
    deliver_city character varying(255),
    deliver_zipcode character varying(255),
    collection_phone character varying(255),
    deliver_phone character varying(255),
    statuscode integer DEFAULT 0 NOT NULL,
    parent_id character varying(255) DEFAULT '0'::character varying NOT NULL,
    collection_address_id integer DEFAULT 0 NOT NULL,
    deliver_address_id integer DEFAULT 0 NOT NULL,
    CONSTRAINT bookings_admin_response_check CHECK (((admin_response)::text = ANY (ARRAY[('pending'::character varying)::text, ('ask_for_qoute'::character varying)::text, ('driver_qouted'::character varying)::text, ('approved_by_admin'::character varying)::text]))),
    CONSTRAINT bookings_is_paid_check CHECK (((is_paid)::text = ANY (ARRAY[('no'::character varying)::text, ('yes'::character varying)::text]))),
    CONSTRAINT bookings_status_check CHECK (((status)::text = ANY (ARRAY[('pending'::character varying)::text, ('qoutes_received'::character varying)::text, ('on_process'::character varying)::text, ('cancelled'::character varying)::text, ('completed'::character varying)::text])))
);


ALTER TABLE public.bookings OWNER TO postgres;

--
-- Name: bookings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bookings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bookings_id_seq OWNER TO postgres;

--
-- Name: bookings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bookings_id_seq OWNED BY public.bookings.id;


--
-- Name: cart_deligate_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cart_deligate_details (
    id bigint NOT NULL,
    item character varying(255),
    booking_cart_id integer,
    no_of_packages integer,
    dimension_of_each_package character varying(255),
    weight_of_each_package character varying(255),
    total_gross_weight integer,
    total_volume_in_cbm character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.cart_deligate_details OWNER TO postgres;

--
-- Name: cart_deligate_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cart_deligate_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cart_deligate_details_id_seq OWNER TO postgres;

--
-- Name: cart_deligate_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cart_deligate_details_id_seq OWNED BY public.cart_deligate_details.id;


--
-- Name: cart_warehousing_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cart_warehousing_details (
    id bigint NOT NULL,
    booking_cart_id integer,
    items_are_stockable character varying(255),
    type_of_storage character varying(255),
    item character varying(255),
    no_of_pallets integer,
    pallet_dimension character varying(255),
    weight_per_pallet integer,
    total_weight integer,
    total_item_cost integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT cart_warehousing_details_items_are_stockable_check CHECK (((items_are_stockable)::text = ANY ((ARRAY['yes'::character varying, 'no'::character varying])::text[])))
);


ALTER TABLE public.cart_warehousing_details OWNER TO postgres;

--
-- Name: cart_warehousing_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cart_warehousing_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cart_warehousing_details_id_seq OWNER TO postgres;

--
-- Name: cart_warehousing_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cart_warehousing_details_id_seq OWNED BY public.cart_warehousing_details.id;


--
-- Name: cities; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cities (
    id bigint NOT NULL,
    city_name character varying(255),
    city_status integer DEFAULT 0 NOT NULL,
    country_id integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.cities OWNER TO postgres;

--
-- Name: cities_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cities_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cities_id_seq OWNER TO postgres;

--
-- Name: cities_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cities_id_seq OWNED BY public.cities.id;


--
-- Name: companies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.companies (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    logo character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    user_id integer,
    license_expiry character varying(255),
    company_license character varying(255),
    CONSTRAINT companies_status_check CHECK (((status)::text = ANY (ARRAY[('active'::character varying)::text, ('inactive'::character varying)::text])))
);


ALTER TABLE public.companies OWNER TO postgres;

--
-- Name: companies_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.companies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.companies_id_seq OWNER TO postgres;

--
-- Name: companies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.companies_id_seq OWNED BY public.companies.id;


--
-- Name: containers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.containers (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    type character varying(255) NOT NULL,
    dimensions character varying(255),
    max_weight_in_metric_tons character varying(255),
    icon character varying(255),
    status character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT containers_status_check CHECK (((status)::text = ANY (ARRAY[('active'::character varying)::text, ('inactive'::character varying)::text]))),
    CONSTRAINT containers_type_check CHECK (((type)::text = ANY (ARRAY[('fcl'::character varying)::text, ('lcl'::character varying)::text])))
);


ALTER TABLE public.containers OWNER TO postgres;

--
-- Name: containers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.containers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.containers_id_seq OWNER TO postgres;

--
-- Name: containers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.containers_id_seq OWNED BY public.containers.id;


--
-- Name: countries; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.countries (
    country_id integer NOT NULL,
    country_name character varying(128) NOT NULL,
    dial_code character varying(16) NOT NULL,
    iso_code character varying(16) NOT NULL,
    lang_code character varying(4) NOT NULL,
    country_status integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.countries OWNER TO postgres;

--
-- Name: countries_country_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.countries_country_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.countries_country_id_seq OWNER TO postgres;

--
-- Name: countries_country_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.countries_country_id_seq OWNED BY public.countries.country_id;


--
-- Name: country_languages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.country_languages (
    country_lang_id integer NOT NULL,
    lang_code character varying(4) NOT NULL,
    country_id_fk integer NOT NULL,
    country_localized_name character varying(128) NOT NULL
);


ALTER TABLE public.country_languages OWNER TO postgres;

--
-- Name: country_languages_country_lang_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.country_languages_country_lang_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.country_languages_country_lang_id_seq OWNER TO postgres;

--
-- Name: country_languages_country_lang_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.country_languages_country_lang_id_seq OWNED BY public.country_languages.country_lang_id;


--
-- Name: deligate_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.deligate_attributes (
    id bigint NOT NULL,
    deligate_id bigint NOT NULL,
    details text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    name character varying(255)
);


ALTER TABLE public.deligate_attributes OWNER TO postgres;

--
-- Name: deligate_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.deligate_attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.deligate_attributes_id_seq OWNER TO postgres;

--
-- Name: deligate_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.deligate_attributes_id_seq OWNED BY public.deligate_attributes.id;


--
-- Name: deligates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.deligates (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    icon character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    slug character varying(255),
    CONSTRAINT deligates_status_check CHECK (((status)::text = ANY (ARRAY[('active'::character varying)::text, ('inactive'::character varying)::text])))
);


ALTER TABLE public.deligates OWNER TO postgres;

--
-- Name: deligates_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.deligates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.deligates_id_seq OWNER TO postgres;

--
-- Name: deligates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.deligates_id_seq OWNED BY public.deligates.id;


--
-- Name: driver_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.driver_details (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    driving_license character varying(255) NOT NULL,
    mulkia character varying(255) NOT NULL,
    mulkia_number character varying(255) NOT NULL,
    is_company character varying(255) DEFAULT 'no'::character varying NOT NULL,
    company_id integer,
    truck_type_id bigint NOT NULL,
    total_rides integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    address character varying(255),
    latitude character varying(255),
    longitude character varying(255),
    emirates_id_or_passport character varying(255),
    driving_license_number character varying(255),
    driving_license_expiry date,
    driving_license_issued_by character varying(255),
    vehicle_plate_number character varying(255),
    vehicle_plate_place character varying(255),
    emirates_id_or_passport_back character varying(255),
    CONSTRAINT driver_details_is_company_check CHECK (((is_company)::text = ANY (ARRAY[('yes'::character varying)::text, ('no'::character varying)::text])))
);


ALTER TABLE public.driver_details OWNER TO postgres;

--
-- Name: driver_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.driver_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.driver_details_id_seq OWNER TO postgres;

--
-- Name: driver_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.driver_details_id_seq OWNED BY public.driver_details.id;


--
-- Name: driver_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.driver_types (
    id integer NOT NULL,
    type character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.driver_types OWNER TO postgres;

--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: faq; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.faq (
    id bigint NOT NULL,
    title character varying(255),
    description text,
    active integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    usertype integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.faq OWNER TO postgres;

--
-- Name: faq_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.faq_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.faq_id_seq OWNER TO postgres;

--
-- Name: faq_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.faq_id_seq OWNED BY public.faq.id;


--
-- Name: help_request; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.help_request (
    id bigint NOT NULL,
    subject character varying(255),
    message text,
    user_id integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.help_request OWNER TO postgres;

--
-- Name: help_request_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.help_request_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.help_request_id_seq OWNER TO postgres;

--
-- Name: help_request_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.help_request_id_seq OWNED BY public.help_request.id;


--
-- Name: languages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.languages (
    language_id integer NOT NULL,
    language_name character varying(255) NOT NULL,
    lang_code character varying(4) DEFAULT 'en'::character varying NOT NULL,
    language_status integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.languages OWNER TO postgres;

--
-- Name: languages_language_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.languages_language_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.languages_language_id_seq OWNER TO postgres;

--
-- Name: languages_language_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.languages_language_id_seq OWNED BY public.languages.language_id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: notification_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notification_users (
    id bigint NOT NULL,
    notification_id integer NOT NULL,
    user_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.notification_users OWNER TO postgres;

--
-- Name: notification_users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notification_users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notification_users_id_seq OWNER TO postgres;

--
-- Name: notification_users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notification_users_id_seq OWNED BY public.notification_users.id;


--
-- Name: notifications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notifications (
    id bigint NOT NULL,
    user_id integer,
    description text,
    generated_by bigint,
    generated_to bigint,
    is_read character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    title character varying(255),
    image character varying(255),
    status character varying(255),
    CONSTRAINT notifications_is_read_check CHECK (((is_read)::text = ANY (ARRAY[('yes'::character varying)::text, ('no'::character varying)::text]))),
    CONSTRAINT notifications_status_check CHECK (((status)::text = ANY (ARRAY[('active'::character varying)::text, ('inactive'::character varying)::text])))
);


ALTER TABLE public.notifications OWNER TO postgres;

--
-- Name: notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notifications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notifications_id_seq OWNER TO postgres;

--
-- Name: notifications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;


--
-- Name: pages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pages (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    status integer DEFAULT 1 NOT NULL,
    slug character varying(255),
    description text,
    meta_title text,
    meta_keyword text,
    meta_description text,
    lang_code character varying(255) DEFAULT 'en'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.pages OWNER TO postgres;

--
-- Name: pages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pages_id_seq OWNER TO postgres;

--
-- Name: pages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pages_id_seq OWNED BY public.pages.id;


--
-- Name: password_resets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO postgres;

--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: role_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.role_permissions (
    permission_id integer NOT NULL,
    user_role_id_fk integer NOT NULL,
    module_key character varying(255) NOT NULL,
    permissions text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.role_permissions OWNER TO postgres;

--
-- Name: role_permissions_permission_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.role_permissions_permission_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.role_permissions_permission_id_seq OWNER TO postgres;

--
-- Name: role_permissions_permission_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.role_permissions_permission_id_seq OWNED BY public.role_permissions.permission_id;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id integer NOT NULL,
    role character varying(255) NOT NULL,
    is_admin_role integer DEFAULT 0 NOT NULL,
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT roles_status_check CHECK (((status)::text = ANY (ARRAY[('active'::character varying)::text, ('inactive'::character varying)::text])))
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.settings (
    id bigint NOT NULL,
    contact_number character varying(255),
    whatsapp_number character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.settings OWNER TO postgres;

--
-- Name: settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.settings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.settings_id_seq OWNER TO postgres;

--
-- Name: settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.settings_id_seq OWNED BY public.settings.id;


--
-- Name: shipping_methods; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.shipping_methods (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    icon character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT shipping_methods_status_check CHECK (((status)::text = ANY (ARRAY[('active'::character varying)::text, ('inactive'::character varying)::text])))
);


ALTER TABLE public.shipping_methods OWNER TO postgres;

--
-- Name: shipping_methods_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shipping_methods_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shipping_methods_id_seq OWNER TO postgres;

--
-- Name: shipping_methods_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.shipping_methods_id_seq OWNED BY public.shipping_methods.id;


--
-- Name: storage_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.storage_types (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT storage_types_status_check CHECK (((status)::text = ANY (ARRAY[('active'::character varying)::text, ('inactive'::character varying)::text])))
);


ALTER TABLE public.storage_types OWNER TO postgres;

--
-- Name: storage_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.storage_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.storage_types_id_seq OWNER TO postgres;

--
-- Name: storage_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.storage_types_id_seq OWNED BY public.storage_types.id;


--
-- Name: temp_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.temp_users (
    temp_user_id integer NOT NULL,
    truck_type character varying(255),
    account_type character varying(255),
    name character varying(255),
    email character varying(255),
    password character varying(255),
    dial_code character varying(255),
    phone character varying(255),
    driving_license character varying(255),
    company_id integer,
    emirates_id_or_passport character varying(255),
    emirates_id_or_passport_back character varying(255),
    user_device_type character varying(255),
    user_device_token character varying(255),
    user_device_id character varying(255),
    driving_license_number character varying(255),
    driving_license_expiry date,
    driving_license_issued_by character varying(255),
    vehicle_plate_number character varying(255),
    vehicle_plate_place character varying(255),
    mulkiya character varying(255),
    mulkiya_number character varying(255),
    status character varying(255),
    address character varying(255),
    country character varying(255),
    city character varying(255),
    zip_code character varying(255),
    latitude character varying(255),
    longitude character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    address_2 text,
    role_id integer DEFAULT 0 NOT NULL,
    country_id integer DEFAULT 0 NOT NULL,
    city_id integer DEFAULT 0 NOT NULL,
    user_phone_otp integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.temp_users OWNER TO postgres;

--
-- Name: temp_users_temp_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.temp_users_temp_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.temp_users_temp_user_id_seq OWNER TO postgres;

--
-- Name: temp_users_temp_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.temp_users_temp_user_id_seq OWNED BY public.temp_users.temp_user_id;


--
-- Name: truck_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.truck_types (
    id bigint NOT NULL,
    truck_type character varying(255) NOT NULL,
    type character varying(255) NOT NULL,
    dimensions character varying(255) NOT NULL,
    icon character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    max_weight_in_tons character varying(255),
    is_container integer DEFAULT 0 NOT NULL,
    CONSTRAINT truck_types_status_check CHECK (((status)::text = ANY (ARRAY[('active'::character varying)::text, ('inactive'::character varying)::text]))),
    CONSTRAINT truck_types_type_check CHECK (((type)::text = ANY (ARRAY[('ftl'::character varying)::text, ('ltl'::character varying)::text])))
);


ALTER TABLE public.truck_types OWNER TO postgres;

--
-- Name: truck_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.truck_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.truck_types_id_seq OWNER TO postgres;

--
-- Name: truck_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.truck_types_id_seq OWNED BY public.truck_types.id;


--
-- Name: user_password_resets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_password_resets (
    id bigint NOT NULL,
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    is_valid character varying(255) DEFAULT '0'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT user_password_resets_is_valid_check CHECK (((is_valid)::text = ANY (ARRAY[('1'::character varying)::text, ('0'::character varying)::text])))
);


ALTER TABLE public.user_password_resets OWNER TO postgres;

--
-- Name: user_password_resets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_password_resets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_password_resets_id_seq OWNER TO postgres;

--
-- Name: user_password_resets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_password_resets_id_seq OWNED BY public.user_password_resets.id;


--
-- Name: user_wallet_transactions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_wallet_transactions (
    id bigint NOT NULL,
    user_wallet_id bigint NOT NULL,
    amount integer NOT NULL,
    type character varying(255) NOT NULL,
    created_by bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT user_wallet_transactions_type_check CHECK (((type)::text = ANY (ARRAY[('credit'::character varying)::text, ('debit'::character varying)::text])))
);


ALTER TABLE public.user_wallet_transactions OWNER TO postgres;

--
-- Name: user_wallet_transactions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_wallet_transactions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_wallet_transactions_id_seq OWNER TO postgres;

--
-- Name: user_wallet_transactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_wallet_transactions_id_seq OWNED BY public.user_wallet_transactions.id;


--
-- Name: user_wallets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_wallets (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    amount integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.user_wallets OWNER TO postgres;

--
-- Name: user_wallets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_wallets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_wallets_id_seq OWNER TO postgres;

--
-- Name: user_wallets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_wallets_id_seq OWNED BY public.user_wallets.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255),
    email character varying(255),
    dial_code character varying(255),
    phone character varying(255),
    phone_verified integer DEFAULT 0 NOT NULL,
    password character varying(255),
    email_verified_at timestamp(0) without time zone,
    role_id bigint NOT NULL,
    user_phone_otp character varying(255),
    user_device_token character varying(255),
    user_device_type character varying(255),
    user_access_token character varying(255),
    firebase_user_key character varying(255),
    status character varying(255) DEFAULT 'inactive'::character varying NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    provider_id character varying(255),
    avatar character varying(255),
    address text,
    profile_image character varying(255),
    is_admin_access integer DEFAULT 0 NOT NULL,
    latitude character varying(255),
    longitude character varying(255),
    country character varying(255),
    city character varying(255),
    zip_code character varying(255),
    address_2 character varying(255),
    user_device_id character varying(255),
    fcm_token text,
    password_reset_otp character varying(255),
    password_reset_time character varying(255),
    login_type character varying(255) DEFAULT 'normal'::character varying NOT NULL,
    country_id integer DEFAULT 0 NOT NULL,
    city_id integer DEFAULT 0 NOT NULL,
    trade_licence_number character varying(255),
    trade_licence_doc character varying(255),
    temp_dialcode character varying(255),
    temp_mobile character varying(255),
    usertype integer DEFAULT 0 NOT NULL,
    CONSTRAINT users_status_check CHECK (((status)::text = ANY (ARRAY[('active'::character varying)::text, ('inactive'::character varying)::text])))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: warehousing_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.warehousing_details (
    id bigint NOT NULL,
    booking_id integer,
    items_are_stockable character varying(255),
    type_of_storage integer,
    item character varying(255),
    pallet_dimension character varying(255),
    weight_per_pallet integer,
    total_weight integer,
    total_item_cost integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    no_of_pallets integer,
    CONSTRAINT warehousing_details_items_are_stockable_check CHECK (((items_are_stockable)::text = ANY (ARRAY[('yes'::character varying)::text, ('no'::character varying)::text])))
);


ALTER TABLE public.warehousing_details OWNER TO postgres;

--
-- Name: warehousing_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.warehousing_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.warehousing_details_id_seq OWNER TO postgres;

--
-- Name: warehousing_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.warehousing_details_id_seq OWNED BY public.warehousing_details.id;


--
-- Name: accepted_qoutes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accepted_qoutes ALTER COLUMN id SET DEFAULT nextval('public.accepted_qoutes_id_seq'::regclass);


--
-- Name: addresses id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.addresses ALTER COLUMN id SET DEFAULT nextval('public.addresses_id_seq'::regclass);


--
-- Name: app_settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.app_settings ALTER COLUMN id SET DEFAULT nextval('public.app_settings_id_seq'::regclass);


--
-- Name: blacklists id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.blacklists ALTER COLUMN id SET DEFAULT nextval('public.blacklists_id_seq'::regclass);


--
-- Name: booking_additional_charges id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_additional_charges ALTER COLUMN id SET DEFAULT nextval('public.booking_additional_charges_id_seq'::regclass);


--
-- Name: booking_carts id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_carts ALTER COLUMN id SET DEFAULT nextval('public.booking_carts_id_seq'::regclass);


--
-- Name: booking_containers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_containers ALTER COLUMN id SET DEFAULT nextval('public.booking_containers_id_seq'::regclass);


--
-- Name: booking_deligate_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_deligate_details ALTER COLUMN id SET DEFAULT nextval('public.booking_deligate_details_id_seq'::regclass);


--
-- Name: booking_qoutes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_qoutes ALTER COLUMN id SET DEFAULT nextval('public.booking_qoutes_id_seq'::regclass);


--
-- Name: booking_reviews id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_reviews ALTER COLUMN id SET DEFAULT nextval('public.booking_reviews_id_seq'::regclass);


--
-- Name: booking_status_trackings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_status_trackings ALTER COLUMN id SET DEFAULT nextval('public.booking_status_trackings_id_seq'::regclass);


--
-- Name: booking_truck_alots id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_truck_alots ALTER COLUMN id SET DEFAULT nextval('public.booking_truck_alots_id_seq'::regclass);


--
-- Name: booking_truck_carts id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_truck_carts ALTER COLUMN id SET DEFAULT nextval('public.booking_truck_carts_id_seq'::regclass);


--
-- Name: booking_trucks id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_trucks ALTER COLUMN id SET DEFAULT nextval('public.booking_trucks_id_seq'::regclass);


--
-- Name: bookings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bookings ALTER COLUMN id SET DEFAULT nextval('public.bookings_id_seq'::regclass);


--
-- Name: cart_deligate_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_deligate_details ALTER COLUMN id SET DEFAULT nextval('public.cart_deligate_details_id_seq'::regclass);


--
-- Name: cart_warehousing_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_warehousing_details ALTER COLUMN id SET DEFAULT nextval('public.cart_warehousing_details_id_seq'::regclass);


--
-- Name: cities id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cities ALTER COLUMN id SET DEFAULT nextval('public.cities_id_seq'::regclass);


--
-- Name: companies id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.companies ALTER COLUMN id SET DEFAULT nextval('public.companies_id_seq'::regclass);


--
-- Name: containers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.containers ALTER COLUMN id SET DEFAULT nextval('public.containers_id_seq'::regclass);


--
-- Name: countries country_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries ALTER COLUMN country_id SET DEFAULT nextval('public.countries_country_id_seq'::regclass);


--
-- Name: country_languages country_lang_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.country_languages ALTER COLUMN country_lang_id SET DEFAULT nextval('public.country_languages_country_lang_id_seq'::regclass);


--
-- Name: deligate_attributes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligate_attributes ALTER COLUMN id SET DEFAULT nextval('public.deligate_attributes_id_seq'::regclass);


--
-- Name: deligates id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligates ALTER COLUMN id SET DEFAULT nextval('public.deligates_id_seq'::regclass);


--
-- Name: driver_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.driver_details ALTER COLUMN id SET DEFAULT nextval('public.driver_details_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: faq id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.faq ALTER COLUMN id SET DEFAULT nextval('public.faq_id_seq'::regclass);


--
-- Name: help_request id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.help_request ALTER COLUMN id SET DEFAULT nextval('public.help_request_id_seq'::regclass);


--
-- Name: languages language_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.languages ALTER COLUMN language_id SET DEFAULT nextval('public.languages_language_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: notification_users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification_users ALTER COLUMN id SET DEFAULT nextval('public.notification_users_id_seq'::regclass);


--
-- Name: notifications id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications ALTER COLUMN id SET DEFAULT nextval('public.notifications_id_seq'::regclass);


--
-- Name: pages id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages ALTER COLUMN id SET DEFAULT nextval('public.pages_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: role_permissions permission_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_permissions ALTER COLUMN permission_id SET DEFAULT nextval('public.role_permissions_permission_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings ALTER COLUMN id SET DEFAULT nextval('public.settings_id_seq'::regclass);


--
-- Name: shipping_methods id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shipping_methods ALTER COLUMN id SET DEFAULT nextval('public.shipping_methods_id_seq'::regclass);


--
-- Name: storage_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.storage_types ALTER COLUMN id SET DEFAULT nextval('public.storage_types_id_seq'::regclass);


--
-- Name: temp_users temp_user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_users ALTER COLUMN temp_user_id SET DEFAULT nextval('public.temp_users_temp_user_id_seq'::regclass);


--
-- Name: truck_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.truck_types ALTER COLUMN id SET DEFAULT nextval('public.truck_types_id_seq'::regclass);


--
-- Name: user_password_resets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_password_resets ALTER COLUMN id SET DEFAULT nextval('public.user_password_resets_id_seq'::regclass);


--
-- Name: user_wallet_transactions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallet_transactions ALTER COLUMN id SET DEFAULT nextval('public.user_wallet_transactions_id_seq'::regclass);


--
-- Name: user_wallets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallets ALTER COLUMN id SET DEFAULT nextval('public.user_wallets_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: warehousing_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.warehousing_details ALTER COLUMN id SET DEFAULT nextval('public.warehousing_details_id_seq'::regclass);


--
-- Data for Name: accepted_qoutes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.accepted_qoutes (id, booking_id, driver_id, hours, qouted_amount, commission_amount, border_charges, shipping_charges, wating_charges, custom_charges, cost_of_truck, received_amount, total_amount, status, created_at, updated_at, booking_truck_id, delivery_note, customer_signature, statuscode) FROM stdin;
2	82	83	10	300	\N	\N	\N	\N	\N	\N	\N	300	accepted	2023-10-16 11:39:06	2023-10-16 15:39:06	\N	\N	\N	0
3	83	83	10	300	\N	\N	\N	\N	\N	\N	\N	300	accepted	2023-10-16 12:01:30	2023-10-16 16:01:30	\N	\N	\N	0
18	112	97	10	300	0	\N	\N	\N	\N	\N	\N	600	delivered	2023-10-24 07:41:59	2023-10-24 11:48:20	102	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	653776c4381fb_1698133700.png	9
17	112	90	10	300	0	\N	\N	\N	\N	\N	\N	600	delivered	2023-10-24 07:36:56	2023-10-24 11:37:37	101	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	653774410b079_1698133057.png	9
19	114	97	10	300	0	\N	\N	\N	\N	\N	\N	600	delivered	2023-10-24 08:09:38	2023-10-24 12:10:23	105	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	65377bef0ebf2_1698135023.png	9
6	102	83	10	300	5	\N	\N	\N	\N	\N	\N	600	delivered	2023-10-17 11:28:26	2023-10-17 15:52:17	86	\N	\N	9
20	115	97	10	500	0	\N	\N	\N	\N	\N	\N	1000	delivered	2023-10-24 08:16:22	2023-10-24 12:16:50	107	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	65377d726d908_1698135410.png	9
21	115	90	10	500	0	\N	\N	\N	\N	\N	\N	1000	delivered	2023-10-24 08:32:07	2023-10-24 12:33:17	106	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	6537814daaf82_1698136397.png	9
22	130	86	24	1000	10	\N	\N	\N	\N	\N	\N	2000	delivered	2023-10-26 07:08:23	2023-10-26 11:24:11	127	good work	653a141b6d15b_1698305051.png	9
5	94	83	2	300	0	\N	\N	\N	\N	\N	\N	600	delivered	2023-10-17 08:56:15	2023-10-18 08:54:27	77	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	652f65032e1b6_1697604867.png	9
23	142	86	24	400	10	\N	\N	\N	\N	\N	\N	800	delivered	2023-10-26 11:20:58	2023-10-26 15:25:42	134	delivered	653a4cb6c80ac_1698319542.png	9
24	149	86	24	300	0	\N	\N	\N	\N	\N	\N	600	accepted	2023-10-26 11:53:22	2023-10-26 11:53:22	146	\N	\N	0
13	106	98	5	300	15	\N	\N	\N	\N	\N	\N	600	delivered	2023-10-20 12:11:59	2023-10-20 16:22:30	95	nothing	6532710621e08_1697804550.png	9
25	149	88	24	300	10	\N	\N	\N	\N	\N	\N	600	accepted	2023-10-26 11:56:18	2023-10-26 11:56:18	146	\N	\N	0
12	106	97	5	250	10	\N	\N	\N	\N	\N	\N	500	delivered	2023-10-20 12:11:55	2023-10-20 16:22:45	96	okay	6532711582105_1697804565.png	9
4	84	83	10	300	10	\N	\N	\N	\N	\N	\N	600	delivered	2023-10-16 12:16:15	2023-10-18 10:23:45	69	testing comments	652f79f1aa080_1697610225.png	9
26	149	107	24	400	10	\N	\N	\N	\N	\N	\N	800	accepted	2023-10-26 11:56:21	2023-10-26 11:56:21	146	\N	\N	0
15	106	88	10	400	10	\N	\N	\N	\N	\N	\N	800	delivered	2023-10-20 12:12:05	2023-10-20 16:23:06	97	okk	6532712a5674d_1697804586.png	9
7	100	83	7	333	0	\N	\N	\N	\N	\N	\N	666	delivered	2023-10-18 20:23:42	2023-10-19 03:29:35	83	test	65306a5f70934_1697671775.png	9
28	153	88	24	250	5	\N	\N	\N	\N	\N	\N	500	delivered	2023-10-26 13:56:29	2023-10-26 17:58:07	149	noted	653a706f10392_1698328687.png	9
16	111	90	10	300	0	\N	\N	\N	\N	\N	\N	600	delivered	2023-10-24 07:26:57	2023-10-24 11:32:59	99	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	6537732b33e3c_1698132779.png	9
8	104	88	2	250	10	\N	\N	\N	\N	\N	\N	500	delivered	2023-10-19 08:45:08	2023-10-19 12:53:08	93	nothing	6530ee741dbd3_1697705588.png	9
10	91	87	11	115	0	\N	\N	\N	\N	\N	\N	230	accepted	2023-10-19 09:30:33	2023-10-19 09:30:33	85	\N	\N	0
9	91	83	10	112	0	\N	\N	\N	\N	\N	\N	224	on_the_way	2023-10-19 09:30:29	2023-10-19 22:01:36	85	\N	\N	6
11	105	83	12	235	0	\N	\N	\N	\N	\N	\N	470	journey_started	2023-10-20 11:45:00	2023-10-20 15:45:33	94	\N	\N	4
14	106	83	15	333	15	\N	\N	\N	\N	\N	\N	666	accepted	2023-10-20 12:12:02	2023-10-20 12:12:02	95	\N	\N	0
27	153	86	24	250	10	\N	\N	\N	\N	\N	\N	500	delivered	2023-10-26 13:56:25	2023-10-26 18:11:39	149	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	653a739b27d36_1698329499.png	9
33	170	111	24	400	15	\N	\N	\N	\N	\N	\N	800	delivered	2023-10-27 07:44:31	2023-10-27 11:50:19	160	done	653b6bbb4f0e6_1698393019.png	9
44	232	139	6	5000	10	\N	\N	\N	\N	\N	\N	10000	delivered	2023-11-14 05:59:31	2023-11-14 10:01:33	197	hhhh	65530d3d5d579_1699941693.png	9
29	158	111	24	250	20	\N	\N	\N	\N	\N	\N	500	delivered	2023-10-27 05:38:39	2023-10-27 09:43:29	151	good	653b4e0135290_1698385409.png	9
34	172	107	24	1000	10	\N	\N	\N	\N	\N	\N	2000	delivered	2023-11-07 07:16:32	2023-11-07 11:19:06	162	dt٠فج	6549e4ea6468f_1699341546.png	9
30	158	86	24	400	20	\N	\N	\N	\N	\N	\N	800	delivered	2023-10-27 05:38:42	2023-10-27 09:46:25	150	done	653b4eb145716_1698385585.png	9
31	161	86	24	250	15	\N	\N	\N	\N	\N	\N	500	delivered	2023-10-27 06:07:31	2023-10-27 10:08:57	154	shipped	653b53f94428e_1698386937.png	9
36	219	139	5	5000	4	\N	\N	\N	\N	\N	\N	10000	journey_started	2023-11-13 11:05:33	2023-11-13 15:10:06	188	\N	\N	4
37	219	139	5	5000	4	\N	\N	\N	\N	\N	\N	10000	journey_started	2023-11-13 11:05:36	2023-11-13 15:10:06	188	\N	\N	4
38	222	37	2	400	15	\N	\N	\N	\N	\N	\N	800	accepted	2023-11-13 11:30:09	2023-11-13 11:30:09	191	\N	\N	0
32	170	114	24	250	5	\N	\N	\N	\N	\N	\N	500	delivered	2023-10-27 07:44:28	2023-10-27 11:49:24	159	delivered	653b6b84cc613_1698392964.png	9
39	222	139	3	5000	10	\N	\N	\N	\N	\N	\N	10000	border_crossing	2023-11-13 11:30:25	2023-11-13 15:34:59	191	\N	\N	7
45	204	97	55	5	0	\N	\N	\N	\N	\N	\N	10	delivered	2023-11-14 07:18:08	2023-11-14 11:24:11	185	Test	6553209ba41af_1699946651.png	9
40	223	132	5	3	0	\N	\N	\N	\N	\N	\N	6	accepted	2023-11-13 12:14:09	2023-11-13 12:14:09	192	\N	\N	0
35	181	83	3	222	0	\N	\N	\N	\N	\N	\N	444	delivered	2023-11-10 12:34:29	2023-11-13 16:26:45	169	ddx	65521605c3f42_1699878405.png	9
41	81	83	10	300	0	\N	\N	\N	\N	\N	\N	600	accepted	2023-11-13 13:33:21	2023-11-13 13:33:21	66	\N	\N	0
42	225	132	22	2	0	\N	\N	\N	\N	\N	\N	4	accepted	2023-11-13 14:38:32	2023-11-13 14:38:32	194	\N	\N	0
43	226	83	12	1234	0	\N	\N	\N	\N	\N	\N	2468	delivered	2023-11-14 05:44:42	2023-11-14 11:27:53	195	test	6553217947cd6_1699946873.png	9
\.


--
-- Data for Name: addresses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.addresses (id, user_id, address, latitude, longitude, city_id, country_id, zip_code, created_at, updated_at, is_deleted, dial_code, phone, building) FROM stdin;
1	16	Building Materials Mall	25.16533880130602	55.46189738501064	1	1	286532	2023-08-08 11:02:42	2023-08-08 11:02:42	0	\N	\N	\N
2	44	Trade Centre	25.224144623109982	55.284972986352955	1	1	286532	2023-08-16 09:16:54	2023-08-16 09:16:54	0	\N	\N	\N
3	44	Premier Inn Dubai Dragon Mart Hotel	25.179631823378383	55.42361689867244	1	1	286532	2023-08-16 21:11:39	2023-08-16 21:11:39	0	\N	\N	\N
4	57	Premier Inn Dubai Dragon Mart Hotel	25.179631823378383	55.42361689867244	1	1	286532	2023-08-18 09:56:41	2023-08-18 09:56:41	0	1	1	\N
5	16	Trade Centre	25.224144623109982	55.284972986352955	1	1	286532	2023-08-18 10:23:29	2023-08-18 10:23:29	0	971	8277272939393939	\N
6	44	Lahore, Punjab, Pakistan	31.520369600000002	74.35874729999999	1	1	5000	2023-08-29 08:24:21	2023-08-29 08:24:21	0	92	030012345678	\N
7	70	Business Bay - Dubai - United Arab Emirates	25.183164700000003	55.272887	1	1	456	2023-09-04 12:04:54	2023-09-04 12:04:54	0	971	5248866658	\N
8	44	Salone Events, The Attic Hangar 8, Goodwood Aerodrome, Chichester PO18 0PH, UK	50.8588586	-0.754575	1	1	PO18 0PH	2023-09-05 09:20:10	2023-09-05 09:20:10	0	92	030012345678	\N
9	74	Trade Centre	25.224144623109982	55.284972986352955	1	1	286532	2023-10-07 10:18:11	2023-10-07 10:18:11	0	971	8277272939393939	\N
10	74	Trade Centre	25.224144623109982	55.284972986352955	1	1	286532	2023-10-07 10:18:13	2023-10-07 10:18:13	0	971	8277272939393939	\N
13	75	Zayed City - Abu Dhabi - United Arab Emirates	23.656830600000003	53.7033803	1	1	356	2023-10-07 17:49:33	2023-10-07 17:49:33	0	971	55424884664	\N
14	73	673C+W8M - Dubai - United Arab Emirates,	25.204851967284775	55.27078282088041	1	1	009	2023-10-09 14:09:00	2023-10-09 14:10:51	1	971	090078601	\N
15	73	673C+W8M - Dubai - United Arab Emirates,	25.204851967284775	55.27078282088041	1	1	009	2023-10-09 14:20:41	2023-10-09 14:20:54	1	971	090078601	\N
28	74	Umm Al Quain	25.26546546	55.5874386546	1	1	286532	2023-10-10 08:39:38	2023-10-10 08:39:38	0	971	8277272939393939	test building
16	73	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	33.51817079839341	73.10975063592196	1	1	1111	2023-10-09 14:58:40	2023-10-09 14:58:45	1	971	090078601	\N
27	77	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	33.51816520792708	73.1097187846899	1	1	28653	2023-10-09 23:09:08	2023-10-10 08:55:17	0	971	1470852369	\N
12	73	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	33.518045571861066	73.10975566506386	1	1	1112	2023-10-07 11:48:35	2023-10-09 15:01:59	0	971	090078601	\N
18	74	Umm Al Quain	25.26546546	55.5874386546	1	1	286532	2023-10-09 15:30:20	2023-10-09 15:30:20	0	971	8277272939393939	\N
19	73	Trade Centre	25.224144623109982	55.284972986352955	1	1	286532	2023-10-09 15:51:25	2023-10-09 15:57:40	1	971	8277272939393939	\N
17	73	Trade Centre	25.224144623109982	55.284972986352955	1	1	286532	2023-10-09 15:20:50	2023-10-09 15:57:44	1	971	8277272939393939	\N
20	77	H48P+PP4, Block A Police Foundation, Islamabad, Punjab, Pakistan,	33.566796971258476	73.1368114426732	1	1	0002	2023-10-09 15:59:31	2023-10-09 16:02:07	1	971	1470852369	\N
21	77	H48P+PP4, Block A Police Foundation, Islamabad, Punjab, Pakistan,	33.56679780935672	73.13680775463581	1	1	0002	2023-10-09 16:03:04	2023-10-09 16:18:31	1	971	1470852369	\N
23	78	238 Second Industrial St - Industrial Area_5 - Industrial Area - Sharjah - United Arab Emirates,	25.33090601907928	55.42093623429537	1	1	562	2023-10-09 17:09:37	2023-10-09 17:16:17	1	971	554251884	\N
24	78	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	25.18418871744177	55.25999028235674	1	1	utu	2023-10-09 17:16:38	2023-10-09 17:16:38	0	971	554251884	\N
22	77	H48P+VP6, Main Main PWD Rd, Block C Police Foundation, Rawalpindi, Punjab, Pakistan,	33.56705063528734	73.13677925616503	1	1	0002	2023-10-09 16:18:56	2023-10-09 22:16:45	1	971	1470852369	\N
26	77	Trade Centre	25.224144623109982	55.284972986352955	2	2	286532	2023-10-09 23:08:25	2023-10-09 23:08:25	0	971	8277272939393939	\N
37	109	17 Al Khwaher St - Jumeirah - Jumeirah 3 - Dubai - United Arab Emirates,	25.190578589794992	55.23016478866339	1	1	q2	2023-10-26 09:22:28	2023-10-26 09:22:28	0	971	554228898	Bayat 1
32	85	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	25.047127821877247	55.15551958233118	1	1	4567	2023-10-18 13:20:54	2023-10-18 16:07:42	0	971	552125893	Bayat Building
29	77	H48P+QXM, Block-A Block A Police Foundation, Islamabad, Punjab, Pakistan,	33.56686848894558	73.13735157251358	2	1	008	2023-10-10 09:08:05	2023-10-10 09:08:05	0	971	1470852369	Building 02
25	77	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	33.51638937801327	73.11086174100637	2	1	009	2023-10-09 23:05:27	2023-10-10 09:13:23	0	971	1470852369	Building Al Khaim
30	73	673C+W8M - Dubai - United Arab Emirates,	25.204851967284775	55.27078282088041	1	1	0098	2023-10-11 09:09:16	2023-10-11 09:09:16	0	971	090078601	building 09
11	73	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	25.194987682373487	55.27841404080391	1	1	0003	2023-10-07 11:39:05	2023-10-11 09:09:52	0	971	090078601	Building 09
31	85	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	25.184237262438835	55.259992964565754	1	1	9876	2023-10-18 13:19:31	2023-10-18 16:06:58	0	971	552125893	Al Manara Tower
33	85	57P5+23F Dubai Creek Boardwalk - Business Bay - Dubai - United Arab Emirates,	25.184102853430804	55.257748290896416	1	1	678	2023-10-18 16:08:12	2023-10-18 16:08:42	1	971	552125893	ghu
34	105	790 B Block, Millat Town Faisalabad, Punjab, Pakistan,	31.488138763909944	73.09930074959993	2	1	2300	2023-10-24 11:37:03	2023-10-24 11:37:03	0	971	3204504501	640 B
35	108	12 Marasi Dr - Business Bay - Bay Square - Dubai - United Arab Emirates,	25.185813143901825	55.2819012477994	1	1	01	2023-10-25 16:28:14	2023-10-25 16:28:14	0	971	524158669	Bay square
36	108	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	25.184230284096706	55.25999095290899	1	1	12	2023-10-25 16:28:58	2023-10-25 16:28:58	0	971	524158669	al manara tower
38	109	Office No: 303, 3rd Floor, Education Zone Bldg - Near Al Qusais Metro Station - اﻟﻘﺼﻴﺺ - القصيص ١ - دبي - United Arab Emirates,	25.276981694222343	55.37242949008942	1	1	09	2023-10-26 09:23:32	2023-10-26 09:23:32	0	971	554228898	al manara
39	110	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	25.184229070471947	55.2599922940135	1	1	12	2023-10-27 09:12:15	2023-10-27 09:12:15	0	971	5341889666	Al Manama
40	110	Sharjah International Airport - Sharjah International Airport - Sharjah - United Arab Emirates,	25.321364732892214	55.520540066063404	1	1	12	2023-10-27 09:12:49	2023-10-27 09:12:49	0	971	5341889666	Bayat
41	110	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	25.184230284096706	55.259993970394135	1	1	01	2023-10-27 09:16:59	2023-10-27 09:17:11	1	971	5341889666	Al Manara
42	113	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	25.184231497721463	55.25999363511801	1	1	10	2023-10-27 11:12:22	2023-10-27 11:12:22	0	971	544568266	Al Manara
43	113	Jumeirah Golf Estates	25.01920789158473	55.2010665088892	1	1	01	2023-10-27 11:13:06	2023-10-27 11:13:26	0	971	544568266	Bayat
44	84	38, Ananda Pally, Jadavpur, Kolkata, West Bengal 700092, India,	22.489859563358984	88.37032735347748	2	1	700032	2023-11-07 11:02:16	2023-11-07 11:02:16	0	971	5515256547	Building 123
45	84	New Delhi	28.613939179213727	77.20902130007744	1	1	110021	2023-11-07 11:03:46	2023-11-07 11:03:46	0	971	5515256547	building 123
47	93	Dubai International Airport (DXB) - Dubai - United Arab Emirates	25.2566466	55.3641488	1	1	673638	2023-11-09 15:29:08	2023-11-09 15:29:08	0	971	7034526952	qvdss
48	137	79XM+M84 - Amman St - opposite of Carrefour Market - Al Qusais Industrial Area - Al Qusais Industrial Area 3 - Dubai - United Arab Emirates,	25.299383033068388	55.38365487009287	2	1	45546656	2023-11-12 15:37:47	2023-11-12 15:37:47	0	971	46466494664	al manara
49	137	79PC+W2M - Al Nahda - Al Nahda 2 - Dubai - United Arab Emirates,	25.287773935101477	55.37035413086414	1	1	46646657	2023-11-12 15:38:19	2023-11-12 15:38:19	0	971	46466494664	yuuu
69	141	45JR+CW4 - Umm Suqeim - Umm Suqeim 3 - Dubai - United Arab Emirates,	25.130547431957964	55.19329313188791	1	1	22	2023-11-13 17:02:32	2023-11-13 17:05:05	1	971	892052473	Test
50	133	7 46th St - Al Jaffiliya - Dubai - United Arab Emirates,	25.239864086059733	55.290537625551224	1	1	Test12	2023-11-13 09:41:33	2023-11-13 09:51:45	1	91	8920524739	Test1234
53	140	673C+W8M - Dubai - United Arab Emirates,	25.204851967284775	55.27078282088041	1	1	9876	2023-11-13 10:07:38	2023-11-13 11:33:15	1	971	1236547890	test
54	140	57PR+HR - Business Bay - Dubai - United Arab Emirates,	25.186422980892413	55.29201988130808	1	1	6445	2023-11-13 10:08:28	2023-11-13 11:33:17	1	971	1236547890	test 2
61	133	6727+556 - 13th St - Al Wasl - Dubai - United Arab Emirates,	25.168942204444328	55.24138446897268	1	1	tsrr	2023-11-13 13:20:44	2023-11-13 13:21:48	1	91	8920524739	del
60	133	673C+W8M - Dubai - United Arab Emirates,	25.20485257399441	55.27078282088041	1	1	test	2023-11-13 13:20:05	2023-11-13 13:21:51	1	91	8920524739	test1
51	133	673C+W8M - Dubai - United Arab Emirates,	25.20485257399441	55.27078282088041	1	1	Test1234	2023-11-13 09:51:36	2023-11-13 12:58:59	1	91	8920524739	Test123
52	133	567R+8R4 - Al Quoz - Al Quoz 3 - Dubai - United Arab Emirates,	25.1633635578166	55.24210296571255	1	1	..........	2023-11-13 09:53:06	2023-11-13 12:59:03	1	91	8920524739	Test12
55	133	1/2, Pusta Number 2, Sonia Vihar, Delhi, 110094, India,	28.723556895889136	77.24526666104794	2	1	hhhh	2023-11-13 12:48:41	2023-11-13 12:59:07	1	91	8920524739	Test123
56	133	673C+W8M - Dubai - United Arab Emirates,	25.20485257399441	55.27078282088041	1	1	1100001	2023-11-13 13:01:27	2023-11-13 13:05:20	1	91	8920524739	Test123
57	133	6739+5C7 - Al Wasl - Dubai - United Arab Emirates,	25.202846168692286	55.26875004172325	2	1	tttyyy	2023-11-13 13:02:57	2023-11-13 13:05:22	1	91	8920524739	test12
58	133	673C+W8M - Dubai - United Arab Emirates,	25.20485257399441	55.27078282088041	2	1	tt	2023-11-13 13:07:04	2023-11-13 13:18:05	1	91	8920524739	Test123
59	133	Dubai Investment Park 2, No: 597-381 - مجمع دبي للإستثمار - دبي - United Arab Emirates,	24.991217186448925	55.168881341814995	1	1	ggg	2023-11-13 13:07:44	2023-11-13 13:18:15	1	91	8920524739	trr
62	133	F93G+HW5 - Al Manhal - Abu Dhabi - United Arab Emirates,	24.453887367074184	54.37734369188547	2	1	ffff	2023-11-13 13:36:59	2023-11-13 13:36:59	0	91	8920524739	er
63	133	673C+W8M - Dubai - United Arab Emirates,	25.20485257399441	55.27078282088041	1	1	223	2023-11-13 13:47:40	2023-11-13 13:47:40	0	91	8920524739	tr
65	140	Dubai Fountain Street 2 - Business Bay - Dubai - United Arab Emirates,	25.19250358653989	55.28692200779915	1	1	369	2023-11-13 15:28:11	2023-11-13 15:35:36	1	971	1236547890	tedt two
64	140	673C+W8M - Dubai - United Arab Emirates,	25.204851967284775	55.27078282088041	1	1	321	2023-11-13 15:27:28	2023-11-13 15:50:08	1	971	1236547890	test one
67	140	40 Al Safa St - Dubai - United Arab Emirates,	25.207590320442	55.265136770904064	1	1	325	2023-11-13 15:49:52	2023-11-13 15:50:29	1	971	1236547890	test
66	140	57XH+39R - Financial Center Rd - Downtown Dubai - Dubai - United Arab Emirates,	25.197745066494228	55.27847472578287	1	1	2580	2023-11-13 15:29:28	2023-11-13 15:50:39	1	971	1236547890	test three
75	145	G929+88J, Poddar Nagar, Jadavpur, Kolkata, West Bengal 700032, India,	22.500724271233974	88.36815275251865	1	1	688699	2023-11-14 12:56:17	2023-11-14 12:56:17	0	971	987466666	Building 321
68	141	673C+W8M - Dubai - United Arab Emirates,	25.20485257399441	55.27078282088041	1	1	25	2023-11-13 17:02:00	2023-11-13 17:05:02	1	971	892052473	test1
70	141	673C+W8M - Dubai - United Arab Emirates,	25.20485257399441	55.27078282088041	1	1	25	2023-11-13 17:05:48	2023-11-13 17:05:48	0	971	892052473	r
76	146	673C+W8M - Dubai - United Arab Emirates,	25.20485257399441	55.27078282088041	1	1	22	2023-11-14 13:08:21	2023-11-14 13:08:21	0	971	8424554646	test1
71	141	Expo Mall Road - Dubai - United Arab Emirates,	24.963634090988485	55.14040030539036	1	1	25	2023-11-13 17:06:13	2023-11-13 17:11:26	0	971	892052473	tesr1
73	142	673C+W8M - Dubai - United Arab Emirates,	25.20485257399441	55.27078282088041	1	1	22	2023-11-13 18:31:20	2023-11-13 18:31:20	0	971	000000000	test
72	142	46VG+6J8 - Al Quoz - Dubai - United Arab Emirates,	25.143800471524028	55.226107612252235	2	1	22	2023-11-13 18:30:47	2023-11-13 18:31:55	0	971	000000000	test
74	145	C/1B, Bapuji Nagar, Jadavpur, Kolkata, West Bengal 700032, India,	22.4893236473253	88.37173450738192	1	1	988569	2023-11-14 12:55:49	2023-11-14 12:55:49	0	971	987466666	Building 123
77	146	39 Street 35 - Al Barsha - Al Barsha South - Dubai - United Arab Emirates,	25.091268543506686	55.24340819567442	1	1	55	2023-11-14 13:09:16	2023-11-14 13:09:16	0	971	8424554646	testtt
\.


--
-- Data for Name: app_settings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.app_settings (id, email, website, contact_numbers, created_at, updated_at) FROM stdin;
1	support@timexshipping.com	www.timexshipping.com	+971234567890	2023-10-10 10:00:00	2023-10-10 10:00:00
\.


--
-- Data for Name: blacklists; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.blacklists (id, user_id, user_device_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: booking_additional_charges; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_additional_charges (id, booking_id, charges_name, charges_amount, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: booking_carts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_carts (id, is_collection, collection_address, deliver_address, sender_id, deligate_id, deligate_type, created_at, updated_at, device_cart_id, booking_number, parent_id) FROM stdin;
135	1	43	42	113	1	ftl	2023-11-07 11:07:29	2023-11-07 11:07:29	30eb4e7290d67788	\N	0
151	1	49	48	137	1	ftl	2023-11-12 15:56:33	2023-11-12 15:56:33	12d4d9f3ec83ed7c	\N	0
265	1	1	3	122	1	ftl	2023-11-13 16:04:37	2023-11-13 16:04:37	JZIATUA	\N	0
310	1	30	11	73	1	ftl	2023-11-14 11:11:36	2023-11-14 11:11:36	507c25ffbc01d8ae	\N	0
\.


--
-- Data for Name: booking_containers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_containers (id, booking_id, container_id, quantity, gross_weight, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: booking_deligate_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_deligate_details (id, item, booking_id, no_of_packages, dimension_of_each_package, weight_of_each_package, total_gross_weight, total_volume_in_cbm, created_at, updated_at) FROM stdin;
1	Fruits	70	10	222	5	50	225	2023-10-09 10:25:10	2023-10-09 10:25:10
2	Cosmetics	71	5	333	3	15	888	2023-10-09 10:36:10	2023-10-09 10:36:10
3	fruits	73	3	2222	12	45	2580	2023-10-09 17:23:34	2023-10-09 17:23:34
4	trst	76	5	222	2580	55	2587	2023-10-09 17:33:44	2023-10-09 17:33:44
5	apples	77	10	222	2	20	555	2023-10-10 17:16:50	2023-10-10 17:16:50
6	test	89	2	258	5	10	685	2023-10-16 17:16:20	2023-10-16 17:16:20
7	yesting	91	2	222	25	25	3258	2023-10-17 09:06:26	2023-10-17 09:06:26
8	testing fruits	105	4	3x2x1	3	12	7x6x5	2023-10-20 13:08:18	2023-10-20 13:08:18
9	phones Item	107	6	2x7x8	1	7	8x9x7	2023-10-20 16:51:40	2023-10-20 16:51:40
10	7447	108	5	25	250	34	25	2023-10-20 16:58:26	2023-10-20 16:58:26
11	45	117	2	25	25	23	12	2023-10-24 14:48:38	2023-10-24 14:48:38
12	363	121	525	13x56	12	42	23	2023-10-25 10:36:38	2023-10-25 10:41:37
13	Groceries	123	10	20	4	3	5	2023-10-25 17:32:34	2023-10-25 17:32:34
14	45	130	34	25	1000	23	12	2023-10-26 10:48:29	2023-10-26 10:48:29
15	123	142	10	5	6	12	10	2023-10-26 15:14:50	2023-10-26 15:14:50
16	Cloths	144	20	2x3x2	10	20	4x8x4	2023-10-26 15:19:53	2023-10-26 15:19:53
17	12	151	15	12x23	25	158	6765	2023-10-26 16:38:41	2023-10-26 16:38:41
18	24	154	2	12053	25	24	2158	2023-10-26 17:14:28	2023-10-26 17:14:28
19	3	155	25	45	21	25	427	2023-10-26 17:15:18	2023-10-26 17:15:18
20	123	157	3	3	4	66	50	2023-10-26 18:22:21	2023-10-26 18:22:21
21	13467	161	2	120x130	23	25	123	2023-10-27 10:02:51	2023-10-27 10:02:51
22	24567	163	25	35356447	12	212	246	2023-10-27 10:12:19	2023-10-27 10:12:19
23	Clothes	165	20	2x3x2	20	20	4x8x4	2023-10-27 10:27:02	2023-10-27 10:27:02
24	353	171	2	120x120	25	25	124	2023-10-27 11:52:31	2023-10-27 11:52:31
25	12	174	1	12	20	40	60	2023-11-09 11:14:14	2023-11-09 11:14:14
26	test	179	12	2x3x4	2	24	5x6x7	2023-11-10 10:47:33	2023-11-10 10:47:33
27	Cloths	187	20	2x3x2	10	20	4x8x4	2023-11-13 10:14:48	2023-11-13 10:14:48
28	Cloths	191	20	2x3x2	10	20	4x8x4	2023-11-13 10:27:35	2023-11-13 10:27:35
29	Test1	200	2	44	52	4	22	2023-11-13 13:49:40	2023-11-13 13:49:40
30	test	202	25	5262	6446	64646	2626	2023-11-13 13:56:48	2023-11-13 13:56:48
31	tedt	205	2	2x2x2	94	34	123	2023-11-13 14:05:33	2023-11-13 14:05:33
32	Cloths	206	20	2x3x2	10	20	4x8x4	2023-11-13 14:09:01	2023-11-13 14:09:01
33	test	207	21	4256	25	57	2131	2023-11-13 14:10:43	2023-11-13 14:10:43
34	tedt	208	3	22	25	67	324	2023-11-13 14:11:50	2023-11-13 14:11:50
35	test again	209	21	123	3	60	654	2023-11-13 14:15:46	2023-11-13 14:15:46
36	test again one	210	3	123	3	9	963	2023-11-13 14:19:06	2023-11-13 14:19:06
37	test again two	211	3	123	3	9	963	2023-11-13 14:19:27	2023-11-13 14:19:27
38	test air	212	2	321	2	4	321	2023-11-13 14:23:05	2023-11-13 14:23:05
39	test air one	213	2	321	2	4	321	2023-11-13 14:23:27	2023-11-13 14:23:27
40	test lcl	218	2	2x2x2	2	4	693	2023-11-13 14:30:09	2023-11-13 14:30:09
41	test ltl truck	227	6	2x3x4	2	12	3215	2023-11-13 22:42:57	2023-11-13 22:42:57
42	test air	228	12	9x8x7	2	24	7654	2023-11-13 22:54:42	2023-11-13 22:54:42
43	test lcl sea	230	13	2x4x5	3	36	6580	2023-11-13 23:24:07	2023-11-13 23:24:07
44	tedt	240	4	55	55	55	2	2023-11-14 13:11:42	2023-11-14 13:11:42
\.


--
-- Data for Name: booking_qoutes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_qoutes (id, booking_id, driver_id, price, hours, status, created_at, updated_at, comission_amount, is_admin_approved, booking_truck_id, qouted_at, statuscode) FROM stdin;
34	111	90	300	10	accepted	2023-10-24 11:22:24	2023-10-24 11:26:57	0	yes	99	2023-10-24 07:24:12	2
26	104	88	250	2	accepted	2023-10-19 12:39:19	2023-10-19 12:45:08	10	yes	93	2023-10-19 08:40:34	2
10	91	83	112	10	accepted	2023-10-17 15:07:45	2023-10-19 13:30:29	0	yes	85	2023-10-17 12:20:49	1
2	82	83	300	10	qouted	2023-10-16 15:31:02	2023-10-16 15:40:02	10	yes	67	2023-10-16 11:36:00	0
25	91	87	115	11	accepted	2023-10-19 12:33:36	2023-10-19 13:30:33	0	yes	85	2023-10-19 08:34:08	1
3	83	83	300	10	qouted	2023-10-16 15:58:23	2023-10-16 16:01:30	10	yes	68	2023-10-16 12:01:00	0
45	120	98	2000	20	qouted	2023-10-25 10:31:59	2023-10-25 10:32:42	0	no	114	2023-10-25 06:32:42	1
27	105	83	235	12	accepted	2023-10-20 13:11:15	2023-10-20 15:45:00	0	yes	94	2023-10-20 11:43:27	2
4	84	83	300	10	accepted	2023-10-16 16:04:21	2023-10-16 16:16:15	10	yes	69	2023-10-16 12:05:29	0
5	86	83	300	10	qouted	2023-10-16 16:30:06	2023-10-16 16:31:46	10	yes	71	2023-10-16 12:31:22	0
36	112	90	300	10	accepted	2023-10-24 11:35:59	2023-10-24 11:36:56	0	yes	101	2023-10-24 07:36:27	2
46	131	61	0	0	pending	2023-10-26 10:51:10	2023-10-26 10:51:10	0	no	126	\N	0
8	98	83	112	5	qouted	2023-10-17 12:45:28	2023-10-17 12:49:35	0	yes	81	2023-10-17 08:48:38	1
6	94	83	300	2	accepted	2023-10-17 10:48:22	2023-10-17 12:56:15	0	yes	77	2023-10-17 08:47:40	2
7	99	71	300	10	qouted	2023-10-17 12:43:12	2023-10-17 15:12:21	0	no	82	2023-10-17 11:12:21	1
37	112	97	300	10	accepted	2023-10-24 11:36:03	2023-10-24 11:41:59	0	yes	102	2023-10-24 07:38:50	2
38	114	90	0	0	pending	2023-10-24 12:08:44	2023-10-24 12:08:44	0	no	104	\N	0
11	102	83	300	10	accepted	2023-10-17 15:17:56	2023-10-17 15:28:26	5	yes	86	2023-10-17 11:18:37	2
12	97	83	0	0	pending	2023-10-18 08:48:46	2023-10-18 08:48:46	0	no	80	\N	0
13	95	83	0	0	pending	2023-10-18 08:51:16	2023-10-18 08:51:16	0	no	78	\N	0
14	89	83	0	0	pending	2023-10-18 08:53:12	2023-10-18 08:53:12	0	no	87	\N	0
15	80	83	0	0	pending	2023-10-18 09:06:22	2023-10-18 09:06:22	0	no	65	\N	0
16	76	83	0	0	pending	2023-10-18 12:27:53	2023-10-18 12:27:53	0	no	89	\N	0
17	73	83	0	0	pending	2023-10-18 12:31:54	2023-10-18 12:31:54	0	no	90	\N	0
18	71	83	0	0	pending	2023-10-18 12:33:18	2023-10-18 12:33:18	0	no	91	\N	0
19	70	83	0	0	pending	2023-10-18 12:45:35	2023-10-18 12:45:35	0	no	92	\N	0
20	68	83	111	7	qouted	2023-10-18 12:50:44	2023-10-18 12:52:13	0	yes	58	2023-10-18 08:51:41	1
39	114	97	300	10	accepted	2023-10-24 12:08:48	2023-10-24 12:09:38	0	yes	105	2023-10-24 08:09:12	2
21	104	86	250	2	qouted	2023-10-18 17:27:30	2023-10-18 17:28:41	10	no	93	2023-10-18 13:28:02	1
22	65	83	0	0	pending	2023-10-18 22:12:59	2023-10-18 22:12:59	0	no	55	\N	0
23	67	83	0	0	pending	2023-10-18 22:13:38	2023-10-18 22:13:38	0	no	57	\N	0
24	101	83	0	0	pending	2023-10-18 22:15:20	2023-10-18 22:15:20	0	no	84	\N	0
9	100	83	333	7	accepted	2023-10-17 13:28:37	2023-10-19 00:23:42	0	yes	83	2023-10-18 19:36:16	2
57	146	97	600	24	qouted	2023-10-26 15:31:44	2023-10-26 15:32:22	16	yes	141	2023-10-26 11:32:09	1
58	146	86	0	0	pending	2023-10-26 15:35:40	2023-10-26 15:35:40	0	no	142	\N	0
41	115	97	500	10	accepted	2023-10-24 12:15:39	2023-10-24 12:16:22	0	yes	107	2023-10-24 08:15:57	2
30	106	97	250	5	accepted	2023-10-20 15:48:28	2023-10-20 16:11:55	10	yes	96	2023-10-20 12:02:38	1
29	106	98	300	5	accepted	2023-10-20 15:48:25	2023-10-20 16:11:59	15	yes	95	2023-10-20 12:04:54	1
28	106	83	333	15	accepted	2023-10-20 15:48:21	2023-10-20 16:12:02	15	yes	95	2023-10-20 11:49:12	1
31	106	88	400	10	accepted	2023-10-20 15:48:32	2023-10-20 16:12:05	10	yes	97	2023-10-20 12:08:02	1
32	108	61	0	0	pending	2023-10-20 17:01:38	2023-10-20 17:01:38	0	no	98	\N	0
33	108	88	250	5	qouted	2023-10-20 17:02:02	2023-10-20 17:04:07	0	no	98	2023-10-20 13:04:07	1
47	130	86	1000	24	accepted	2023-10-26 10:53:51	2023-10-26 11:08:23	10	yes	127	2023-10-26 06:57:03	2
48	132	37	0	0	pending	2023-10-26 11:25:07	2023-10-26 11:25:07	0	no	128	\N	0
49	132	65	0	0	pending	2023-10-26 11:25:07	2023-10-26 11:25:07	0	no	128	\N	0
40	115	90	500	10	accepted	2023-10-24 12:15:35	2023-10-24 12:32:07	0	yes	106	2023-10-24 08:17:45	2
42	116	92	0	0	pending	2023-10-24 14:51:06	2023-10-24 14:51:06	0	no	108	\N	0
50	132	59	0	0	pending	2023-10-26 11:25:07	2023-10-26 11:25:07	0	no	128	\N	0
44	118	98	100	3	qouted	2023-10-24 16:40:59	2023-10-24 16:45:24	0	no	110	2023-10-24 12:45:24	1
51	132	66	0	0	pending	2023-10-26 11:25:07	2023-10-26 11:25:07	0	no	128	\N	0
52	135	86	0	0	pending	2023-10-26 11:41:11	2023-10-26 11:41:11	0	no	129	\N	0
53	139	66	0	0	pending	2023-10-26 12:36:47	2023-10-26 12:36:47	0	no	130	\N	0
54	140	64	0	0	pending	2023-10-26 12:43:38	2023-10-26 12:44:22	2	no	131	\N	0
55	138	65	0	0	pending	2023-10-26 14:50:13	2023-10-26 14:50:13	0	no	\N	\N	0
56	142	86	400	24	accepted	2023-10-26 15:16:39	2023-10-26 15:20:58	10	yes	134	2023-10-26 11:17:45	2
59	149	86	300	24	accepted	2023-10-26 15:51:12	2023-10-26 15:53:22	0	yes	146	2023-10-26 11:52:33	2
61	149	107	400	24	accepted	2023-10-26 15:51:19	2023-10-26 15:56:21	10	yes	146	2023-10-26 11:55:40	1
60	149	88	300	24	accepted	2023-10-26 15:51:15	2023-10-26 15:56:18	10	yes	146	2023-10-26 11:54:30	1
63	153	88	250	24	accepted	2023-10-26 17:54:27	2023-10-26 17:56:29	5	yes	149	2023-10-26 13:55:31	1
62	153	86	250	24	accepted	2023-10-26 17:54:23	2023-10-26 17:56:25	10	yes	149	2023-10-26 13:54:44	1
65	158	111	250	24	accepted	2023-10-27 09:32:52	2023-10-27 09:38:39	20	yes	151	2023-10-27 05:35:14	1
64	158	86	400	24	accepted	2023-10-27 09:32:48	2023-10-27 09:38:42	20	yes	150	2023-10-27 05:35:30	1
66	161	86	250	24	accepted	2023-10-27 10:04:16	2023-10-27 10:07:31	15	yes	154	2023-10-27 06:04:43	2
43	116	97	5550	2	qouted	2023-10-24 14:51:09	2023-11-11 14:20:21	3	yes	109	2023-11-11 10:20:21	1
35	111	97	2	2	qouted	2023-10-24 11:22:28	2023-11-13 15:06:29	0	no	100	2023-11-13 11:06:29	1
1	81	83	300	10	accepted	2023-10-11 09:27:58	2023-11-13 17:33:21	0	yes	66	2023-10-16 11:02:38	2
86	223	58	10	1	qouted	2023-11-13 15:57:21	2023-11-13 16:39:53	0	yes	192	2023-11-13 12:39:26	1
87	223	37	0	0	pending	2023-11-13 16:45:46	2023-11-13 16:45:46	0	no	192	\N	0
88	223	61	0	0	pending	2023-11-13 16:46:38	2023-11-13 16:46:38	0	no	192	\N	0
89	223	61	0	0	pending	2023-11-13 16:47:20	2023-11-13 16:47:20	0	no	192	\N	0
90	223	64	0	0	pending	2023-11-13 16:47:36	2023-11-13 16:47:36	0	no	192	\N	0
67	170	114	250	24	accepted	2023-10-27 11:40:11	2023-10-27 11:44:28	5	yes	159	2023-10-27 07:41:28	1
68	170	111	400	24	accepted	2023-10-27 11:40:14	2023-10-27 11:44:31	15	yes	160	2023-10-27 07:42:02	1
69	169	58	0	0	pending	2023-11-01 13:44:53	2023-11-01 13:44:53	0	no	161	\N	0
70	169	59	0	0	pending	2023-11-01 13:44:56	2023-11-01 13:44:56	0	no	161	\N	0
71	169	64	0	0	pending	2023-11-01 13:44:59	2023-11-01 13:45:20	10	no	161	\N	0
72	167	59	0	0	pending	2023-11-07 10:55:41	2023-11-07 10:55:41	0	no	158	\N	0
73	167	61	0	0	pending	2023-11-07 10:55:45	2023-11-07 10:55:45	0	no	158	\N	0
74	167	65	1000	24	qouted	2023-11-07 10:55:47	2023-11-07 10:56:53	10	no	158	2023-11-07 06:56:53	1
76	172	114	0	0	pending	2023-11-07 11:12:15	2023-11-07 11:12:15	0	no	162	\N	0
91	225	132	2	22	accepted	2023-11-13 18:33:31	2023-11-13 18:38:32	0	yes	194	2023-11-13 14:37:39	2
75	172	107	1000	24	accepted	2023-11-07 11:12:12	2023-11-07 11:16:32	10	yes	162	2023-11-07 07:15:19	2
77	177	65	0	0	pending	2023-11-09 17:44:45	2023-11-09 17:44:45	0	no	166	\N	0
79	181	83	222	3	accepted	2023-11-10 16:30:33	2023-11-10 16:34:29	0	yes	169	2023-11-10 12:30:57	2
92	223	97	2	55	qouted	2023-11-13 18:55:06	2023-11-13 18:58:04	0	no	192	2023-11-13 14:58:04	1
93	223	97	2	55	qouted	2023-11-13 18:57:42	2023-11-13 18:58:04	0	no	192	2023-11-13 14:58:04	1
94	223	97	2	55	qouted	2023-11-13 19:04:22	2023-11-13 19:04:41	0	no	192	2023-11-13 15:04:41	1
78	178	97	22	2	qouted	2023-11-10 07:57:10	2023-11-13 15:04:20	0	no	167	2023-11-13 11:04:20	1
81	219	139	5000	5	accepted	2023-11-13 14:58:07	2023-11-13 15:05:33	4	yes	188	2023-11-13 10:58:53	1
80	219	139	5000	5	accepted	2023-11-13 14:57:59	2023-11-13 15:05:36	4	yes	188	2023-11-13 10:58:53	1
96	226	83	1234	12	accepted	2023-11-14 09:41:14	2023-11-14 09:44:42	0	yes	195	2023-11-14 05:42:21	2
83	222	37	400	2	accepted	2023-11-13 15:27:37	2023-11-13 15:30:09	15	yes	191	2023-11-13 11:28:17	1
82	222	139	5000	3	accepted	2023-11-13 15:25:04	2023-11-13 15:30:25	10	yes	191	2023-11-13 11:26:24	1
84	222	132	0	0	pending	2023-11-13 15:41:54	2023-11-13 15:41:54	0	no	191	\N	0
97	232	139	5000	77	qouted	2023-11-14 09:56:21	2023-11-14 10:10:39	66	yes	197	2023-11-14 06:10:39	1
85	223	132	3	5	accepted	2023-11-13 15:51:56	2023-11-13 16:14:09	0	yes	192	2023-11-13 12:00:05	2
95	223	97	5	55	qouted	2023-11-13 19:10:12	2023-11-14 11:15:23	0	no	192	2023-11-14 07:15:23	1
98	204	97	5	55	accepted	2023-11-14 11:14:00	2023-11-14 11:18:08	0	yes	185	2023-11-14 07:17:37	2
99	233	111	2	55	qouted	2023-11-14 11:46:39	2023-11-14 12:39:37	0	yes	\N	2023-11-14 08:39:21	1
100	234	37	10	1	qouted	2023-11-14 13:01:13	2023-11-14 13:01:43	0	yes	199	2023-11-14 09:01:32	1
\.


--
-- Data for Name: booking_reviews; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_reviews (id, booking_id, customer_id, rate, comment, created_at, updated_at, status, updated_by) FROM stdin;
3	106	85	4	love your service	2023-10-20 12:28:51	2023-10-20 16:55:35	approve	1
2	94	73	2	test 2.5	2023-10-19 08:24:11	2023-10-20 16:55:49	approve	1
1	100	73	3	testing	2023-10-19 07:22:34	2023-10-20 16:55:59	approve	1
4	130	108	5	Nice to work with timex	2023-10-26 07:24:45	2023-10-26 12:40:57	approve	1
6	158	110	4.5	Good service	2023-10-27 05:50:08	2023-10-27 10:22:11	approve	1
5	142	73	4	good	2023-10-26 11:26:26	2023-10-27 10:22:20	approve	1
7	170	113	5	Good service	2023-10-27 07:50:51	2023-10-27 07:50:51	pending	\N
\.


--
-- Data for Name: booking_status_trackings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_status_trackings (id, booking_id, status_tracking, created_at, updated_at, driver_id, statuscode, quote_id) FROM stdin;
1	84	request_created	2023-10-16 16:03:48	2023-10-16 16:03:48	83	0	0
3	94	request_created	2023-10-17 10:47:21	2023-10-17 10:47:21	83	0	0
5	102	request_created	2023-10-17 15:17:05	2023-10-17 15:17:05	83	0	0
77	111	request_created	2023-10-24 11:21:33	2023-10-24 11:21:33	90	0	16
78	111	accepted	2023-10-24 07:26:57	2023-10-24 11:21:33	90	2	16
80	111	item_collected	2023-10-24 07:32:28	2023-10-24 07:32:28	90	5	16
82	111	border_crossing	2023-10-24 07:32:38	2023-10-24 07:32:38	90	7	16
84	111	delivered	2023-10-24 07:32:59	2023-10-24 07:32:59	90	9	16
87	112	journey_started	2023-10-24 07:37:12	2023-10-24 07:37:12	90	4	17
89	112	on_the_way	2023-10-24 07:37:22	2023-10-24 07:37:22	90	6	17
91	112	custom_clearance	2023-10-24 07:37:31	2023-10-24 07:37:31	90	8	17
93	112	request_created	2023-10-24 11:35:07	2023-10-24 11:35:07	97	0	18
94	112	accepted	2023-10-24 07:41:59	2023-10-24 11:35:07	97	2	18
96	112	item_collected	2023-10-24 07:42:21	2023-10-24 07:42:21	97	5	18
98	112	border_crossing	2023-10-24 07:42:30	2023-10-24 07:42:30	97	7	18
161	153	delivered	2023-10-26 14:11:39	2023-10-26 14:11:39	86	9	27
100	112	delivered	2023-10-24 07:48:20	2023-10-24 07:48:20	97	9	18
25	100	request_created	2023-10-17 13:27:58	2023-10-17 13:27:58	83	0	0
103	114	journey_started	2023-10-24 08:09:59	2023-10-24 08:09:59	97	4	19
105	114	on_the_way	2023-10-24 08:10:07	2023-10-24 08:10:07	97	6	19
107	114	custom_clearance	2023-10-24 08:10:14	2023-10-24 08:10:14	97	8	19
109	115	request_created	2023-10-24 12:11:37	2023-10-24 12:11:37	97	0	20
110	115	accepted	2023-10-24 08:16:22	2023-10-24 12:11:37	97	2	20
33	104	request_created	2023-10-18 16:28:07	2023-10-18 16:28:07	88	0	0
112	115	delivered	2023-10-24 08:16:50	2023-10-24 08:16:50	97	9	20
115	115	journey_started	2023-10-24 08:32:57	2023-10-24 08:32:57	90	4	21
117	115	on_the_way	2023-10-24 08:33:05	2023-10-24 08:33:05	90	6	21
119	115	custom_clearance	2023-10-24 08:33:12	2023-10-24 08:33:12	90	8	21
121	120	request_created	2023-10-25 10:31:59	2023-10-25 10:31:59	\N	0	0
41	91	request_created	2023-10-17 09:06:26	2023-10-17 09:06:26	83	0	0
43	91	request_created	2023-10-17 09:06:26	2023-10-17 09:06:26	87	0	0
122	128	request_created	2023-10-26 10:28:00	2023-10-26 10:28:00	\N	0	0
124	131	request_created	2023-10-26 10:51:10	2023-10-26 10:51:10	\N	0	0
48	105	request_created	2023-10-20 13:08:18	2023-10-20 13:08:18	83	0	0
127	130	journey_started	2023-10-26 07:10:21	2023-10-26 07:10:21	86	4	22
129	130	on_the_way	2023-10-26 07:23:12	2023-10-26 07:23:12	86	6	22
131	130	custom_clearance	2023-10-26 07:23:45	2023-10-26 07:23:45	86	8	22
133	132	request_created	2023-10-26 11:25:07	2023-10-26 11:25:07	\N	0	0
135	135	request_created	2023-10-26 11:41:11	2023-10-26 11:41:11	\N	0	0
137	140	request_created	2023-10-26 12:43:38	2023-10-26 12:43:38	64	0	0
140	142	journey_started	2023-10-26 11:24:24	2023-10-26 11:24:24	86	4	23
142	142	on_the_way	2023-10-26 11:25:05	2023-10-26 11:25:05	86	6	23
144	142	custom_clearance	2023-10-26 11:25:23	2023-10-26 11:25:23	86	8	23
146	149	request_created	2023-10-26 15:46:35	2023-10-26 15:46:35	86	0	24
147	149	accepted	2023-10-26 11:53:22	2023-10-26 15:46:35	86	2	24
152	153	request_created	2023-10-26 17:12:44	2023-10-26 17:12:44	86	0	27
153	153	accepted	2023-10-26 13:56:25	2023-10-26 17:12:44	86	2	27
154	153	request_created	2023-10-26 17:12:44	2023-10-26 17:12:44	88	0	28
155	153	accepted	2023-10-26 13:56:29	2023-10-26 17:12:44	88	2	28
2	84	accepted	2023-10-16 12:16:15	2023-10-16 16:03:48	83	2	0
4	94	accepted	2023-10-17 08:56:15	2023-10-17 10:47:21	83	2	0
6	102	accepted	2023-10-17 11:28:26	2023-10-17 15:17:05	83	2	0
26	100	accepted	2023-10-18 20:23:42	2023-10-17 13:27:58	83	2	0
34	104	accepted	2023-10-19 08:45:08	2023-10-18 16:28:07	88	2	0
42	91	accepted	2023-10-19 09:30:29	2023-10-17 09:06:26	83	2	0
44	91	accepted	2023-10-19 09:30:33	2023-10-17 09:06:26	87	2	0
49	105	accepted	2023-10-20 11:45:00	2023-10-20 13:08:18	83	2	0
157	153	item_collected	2023-10-26 13:57:13	2023-10-26 13:57:13	86	5	27
159	153	border_crossing	2023-10-26 13:57:20	2023-10-26 13:57:20	86	7	27
163	153	item_collected	2023-10-26 13:57:50	2023-10-26 13:57:50	88	5	28
7	102	journey_started	2023-10-17 11:38:14	2023-10-17 11:38:14	83	4	0
13	94	journey_started	2023-10-17 12:57:51	2023-10-17 12:57:51	83	4	0
19	84	journey_started	2023-10-18 06:13:27	2023-10-18 06:13:27	83	4	0
27	100	journey_started	2023-10-18 23:18:01	2023-10-18 23:18:01	83	4	0
35	104	journey_started	2023-10-19 08:47:58	2023-10-19 08:47:58	88	4	0
45	91	journey_started	2023-10-19 11:39:53	2023-10-19 11:39:53	83	4	0
50	105	journey_started	2023-10-20 11:45:34	2023-10-20 11:45:34	83	4	0
165	153	border_crossing	2023-10-26 13:57:56	2023-10-26 13:57:56	88	7	28
167	153	delivered	2023-10-26 13:58:07	2023-10-26 13:58:07	88	9	28
174	158	on_the_way	2023-10-27 05:42:55	2023-10-27 05:42:55	111	6	29
9	102	on_the_way	2023-10-17 11:39:39	2023-10-17 11:39:39	83	6	0
53	106	request_created	2023-10-20 15:42:41	2023-10-20 15:42:41	98	0	13
54	106	accepted	2023-10-20 12:11:59	2023-10-20 15:42:41	98	2	13
59	106	journey_started	2023-10-20 12:16:22	2023-10-20 12:16:22	98	4	13
51	106	request_created	2023-10-20 15:42:41	2023-10-20 15:42:41	97	0	12
52	106	accepted	2023-10-20 12:11:55	2023-10-20 15:42:41	97	2	12
60	106	journey_started	2023-10-20 12:19:17	2023-10-20 12:19:17	97	4	12
57	106	request_created	2023-10-20 15:42:41	2023-10-20 15:42:41	88	0	15
58	106	accepted	2023-10-20 12:12:05	2023-10-20 15:42:41	88	2	15
61	106	journey_started	2023-10-20 12:21:03	2023-10-20 12:21:03	88	4	15
55	106	request_created	2023-10-20 15:42:41	2023-10-20 15:42:41	83	0	14
56	106	accepted	2023-10-20 12:12:02	2023-10-20 15:42:41	83	2	14
172	158	journey_started	2023-10-27 05:42:32	2023-10-27 05:42:32	111	4	29
175	158	border_crossing	2023-10-27 05:43:03	2023-10-27 05:43:03	111	7	29
176	158	custom_clearance	2023-10-27 05:43:10	2023-10-27 05:43:10	111	8	29
177	158	delivered	2023-10-27 05:43:29	2023-10-27 05:43:29	111	9	29
178	158	journey_started	2023-10-27 05:45:19	2023-10-27 05:45:19	86	4	30
179	158	item_collected	2023-10-27 05:45:37	2023-10-27 05:45:37	86	5	30
180	158	on_the_way	2023-10-27 05:45:58	2023-10-27 05:45:58	86	6	30
181	158	border_crossing	2023-10-27 05:46:03	2023-10-27 05:46:03	86	7	30
182	158	custom_clearance	2023-10-27 05:46:11	2023-10-27 05:46:11	86	8	30
8	102	item_collected	2023-10-17 11:39:34	2023-10-17 11:39:34	83	5	0
14	94	item_collected	2023-10-17 17:16:10	2023-10-17 17:16:10	83	5	0
20	84	item_collected	2023-10-18 06:15:00	2023-10-18 06:15:00	83	5	0
28	100	item_collected	2023-10-18 23:23:03	2023-10-18 23:23:03	83	5	0
36	104	item_collected	2023-10-19 08:50:02	2023-10-19 08:50:02	88	5	0
46	91	item_collected	2023-10-19 16:40:39	2023-10-19 16:40:39	83	5	0
15	94	on_the_way	2023-10-17 17:40:57	2023-10-17 17:40:57	83	6	0
21	84	on_the_way	2023-10-18 06:16:09	2023-10-18 06:16:09	83	6	0
29	100	on_the_way	2023-10-18 23:25:29	2023-10-18 23:25:29	83	6	0
37	104	on_the_way	2023-10-19 08:51:30	2023-10-19 08:51:30	88	6	0
47	91	on_the_way	2023-10-19 18:01:37	2023-10-19 18:01:37	83	6	0
10	102	border_crossing	2023-10-17 11:52:00	2023-10-17 11:52:00	83	7	0
16	94	border_crossing	2023-10-17 17:44:37	2023-10-17 17:44:37	83	7	0
22	84	border_crossing	2023-10-18 06:17:36	2023-10-18 06:17:36	83	7	0
30	100	border_crossing	2023-10-18 23:26:19	2023-10-18 23:26:19	83	7	0
38	104	border_crossing	2023-10-19 08:52:01	2023-10-19 08:52:01	88	7	0
11	102	custom_clearance	2023-10-17 11:52:10	2023-10-17 11:52:10	83	8	0
17	94	custom_clearance	2023-10-17 17:45:44	2023-10-17 17:45:44	83	8	0
23	84	custom_clearance	2023-10-18 06:18:35	2023-10-18 06:18:35	83	8	0
31	100	custom_clearance	2023-10-18 23:28:18	2023-10-18 23:28:18	83	8	0
39	104	custom_clearance	2023-10-19 08:52:17	2023-10-19 08:52:17	88	8	0
12	102	delivered	2023-10-17 11:52:21	2023-10-17 11:52:21	83	9	0
18	94	delivered	2023-10-18 04:54:27	2023-10-18 04:54:27	83	9	0
24	84	delivered	2023-10-18 06:23:45	2023-10-18 06:23:45	83	9	0
32	100	delivered	2023-10-18 23:29:35	2023-10-18 23:29:35	83	9	0
40	104	delivered	2023-10-19 08:53:08	2023-10-19 08:53:08	88	9	0
63	106	item_collected	2023-10-20 12:21:25	2023-10-20 12:21:25	98	5	13
66	106	on_the_way	2023-10-20 12:21:37	2023-10-20 12:21:37	98	6	13
69	106	border_crossing	2023-10-20 12:21:50	2023-10-20 12:21:50	98	7	13
71	106	custom_clearance	2023-10-20 12:21:59	2023-10-20 12:21:59	98	8	13
74	106	delivered	2023-10-20 12:22:30	2023-10-20 12:22:30	98	9	13
62	106	item_collected	2023-10-20 12:21:21	2023-10-20 12:21:21	97	5	12
67	106	on_the_way	2023-10-20 12:21:39	2023-10-20 12:21:39	97	6	12
68	106	border_crossing	2023-10-20 12:21:45	2023-10-20 12:21:45	97	7	12
72	106	custom_clearance	2023-10-20 12:22:01	2023-10-20 12:22:01	97	8	12
75	106	delivered	2023-10-20 12:22:45	2023-10-20 12:22:45	97	9	12
64	106	item_collected	2023-10-20 12:21:27	2023-10-20 12:21:27	88	5	15
65	106	on_the_way	2023-10-20 12:21:34	2023-10-20 12:21:34	88	6	15
70	106	border_crossing	2023-10-20 12:21:54	2023-10-20 12:21:54	88	7	15
73	106	custom_clearance	2023-10-20 12:22:05	2023-10-20 12:22:05	88	8	15
76	106	delivered	2023-10-20 12:23:06	2023-10-20 12:23:06	88	9	15
79	111	journey_started	2023-10-24 07:32:22	2023-10-24 07:32:22	90	4	16
81	111	on_the_way	2023-10-24 07:32:33	2023-10-24 07:32:33	90	6	16
83	111	custom_clearance	2023-10-24 07:32:43	2023-10-24 07:32:43	90	8	16
85	112	request_created	2023-10-24 11:35:07	2023-10-24 11:35:07	90	0	17
86	112	accepted	2023-10-24 07:36:56	2023-10-24 11:35:07	90	2	17
88	112	item_collected	2023-10-24 07:37:17	2023-10-24 07:37:17	90	5	17
90	112	border_crossing	2023-10-24 07:37:27	2023-10-24 07:37:27	90	7	17
92	112	delivered	2023-10-24 07:37:37	2023-10-24 07:37:37	90	9	17
95	112	journey_started	2023-10-24 07:42:17	2023-10-24 07:42:17	97	4	18
97	112	on_the_way	2023-10-24 07:42:25	2023-10-24 07:42:25	97	6	18
99	112	custom_clearance	2023-10-24 07:42:34	2023-10-24 07:42:34	97	8	18
101	114	request_created	2023-10-24 11:51:13	2023-10-24 11:51:13	97	0	19
102	114	accepted	2023-10-24 08:09:38	2023-10-24 11:51:13	97	2	19
104	114	item_collected	2023-10-24 08:10:03	2023-10-24 08:10:03	97	5	19
106	114	border_crossing	2023-10-24 08:10:11	2023-10-24 08:10:11	97	7	19
108	114	delivered	2023-10-24 08:10:23	2023-10-24 08:10:23	97	9	19
111	115	custom_clearance	2023-10-24 08:16:39	2023-10-24 08:16:39	97	8	20
113	115	request_created	2023-10-24 12:11:37	2023-10-24 12:11:37	90	0	21
114	115	accepted	2023-10-24 08:32:07	2023-10-24 12:11:37	90	2	21
116	115	item_collected	2023-10-24 08:33:01	2023-10-24 08:33:01	90	5	21
118	115	border_crossing	2023-10-24 08:33:08	2023-10-24 08:33:08	90	7	21
120	115	delivered	2023-10-24 08:33:17	2023-10-24 08:33:17	90	9	21
123	129	request_created	2023-10-26 10:28:43	2023-10-26 10:28:43	\N	0	0
125	130	request_created	2023-10-26 10:48:29	2023-10-26 10:48:29	86	0	22
126	130	accepted	2023-10-26 07:08:23	2023-10-26 10:48:29	86	2	22
128	130	item_collected	2023-10-26 07:22:23	2023-10-26 07:22:23	86	5	22
130	130	border_crossing	2023-10-26 07:23:29	2023-10-26 07:23:29	86	7	22
132	130	delivered	2023-10-26 07:24:11	2023-10-26 07:24:11	86	9	22
134	134	request_created	2023-10-26 11:36:57	2023-10-26 11:36:57	\N	0	0
136	139	request_created	2023-10-26 12:36:47	2023-10-26 12:36:47	\N	0	0
138	142	request_created	2023-10-26 15:14:50	2023-10-26 15:14:50	86	0	23
139	142	accepted	2023-10-26 11:20:58	2023-10-26 15:14:50	86	2	23
141	142	item_collected	2023-10-26 11:24:55	2023-10-26 11:24:55	86	5	23
143	142	border_crossing	2023-10-26 11:25:14	2023-10-26 11:25:14	86	7	23
145	142	delivered	2023-10-26 11:25:42	2023-10-26 11:25:42	86	9	23
148	149	request_created	2023-10-26 15:46:35	2023-10-26 15:46:35	88	0	25
149	149	accepted	2023-10-26 11:56:18	2023-10-26 15:46:35	88	2	25
150	149	request_created	2023-10-26 15:46:35	2023-10-26 15:46:35	107	0	26
151	149	accepted	2023-10-26 11:56:21	2023-10-26 15:46:35	107	2	26
156	153	journey_started	2023-10-26 13:57:03	2023-10-26 13:57:03	86	4	27
158	153	on_the_way	2023-10-26 13:57:17	2023-10-26 13:57:17	86	6	27
160	153	custom_clearance	2023-10-26 13:57:23	2023-10-26 13:57:23	86	8	27
162	153	journey_started	2023-10-26 13:57:47	2023-10-26 13:57:47	88	4	28
164	153	on_the_way	2023-10-26 13:57:52	2023-10-26 13:57:52	88	6	28
166	153	custom_clearance	2023-10-26 13:57:58	2023-10-26 13:57:58	88	8	28
168	158	request_created	2023-10-27 09:13:45	2023-10-27 09:13:45	111	0	29
169	158	accepted	2023-10-27 05:38:39	2023-10-27 09:13:45	111	2	29
170	158	request_created	2023-10-27 09:13:45	2023-10-27 09:13:45	86	0	30
171	158	accepted	2023-10-27 05:38:42	2023-10-27 09:13:45	86	2	30
173	158	item_collected	2023-10-27 05:42:47	2023-10-27 05:42:47	111	5	29
183	158	delivered	2023-10-27 05:46:25	2023-10-27 05:46:25	86	9	30
184	161	request_created	2023-10-27 10:02:51	2023-10-27 10:02:51	86	0	31
185	161	accepted	2023-10-27 06:07:31	2023-10-27 10:02:51	86	2	31
186	161	journey_started	2023-10-27 06:08:00	2023-10-27 06:08:00	86	4	31
187	161	item_collected	2023-10-27 06:08:05	2023-10-27 06:08:05	86	5	31
188	161	on_the_way	2023-10-27 06:08:10	2023-10-27 06:08:10	86	6	31
189	161	border_crossing	2023-10-27 06:08:39	2023-10-27 06:08:39	86	7	31
190	161	custom_clearance	2023-10-27 06:08:42	2023-10-27 06:08:42	86	8	31
191	161	delivered	2023-10-27 06:08:57	2023-10-27 06:08:57	86	9	31
192	170	request_created	2023-10-27 11:16:13	2023-10-27 11:16:13	114	0	32
193	170	accepted	2023-10-27 07:44:28	2023-10-27 11:16:13	114	2	32
194	170	request_created	2023-10-27 11:16:13	2023-10-27 11:16:13	111	0	33
195	170	accepted	2023-10-27 07:44:31	2023-10-27 11:16:13	111	2	33
196	170	journey_started	2023-10-27 07:46:31	2023-10-27 07:46:31	114	4	32
197	170	journey_started	2023-10-27 07:47:29	2023-10-27 07:47:29	111	4	33
198	170	item_collected	2023-10-27 07:47:50	2023-10-27 07:47:50	111	5	33
199	170	item_collected	2023-10-27 07:47:52	2023-10-27 07:47:52	114	5	32
200	170	on_the_way	2023-10-27 07:48:24	2023-10-27 07:48:24	114	6	32
201	170	border_crossing	2023-10-27 07:48:27	2023-10-27 07:48:27	114	7	32
202	170	custom_clearance	2023-10-27 07:49:02	2023-10-27 07:49:02	114	8	32
203	170	delivered	2023-10-27 07:49:24	2023-10-27 07:49:24	114	9	32
204	170	on_the_way	2023-10-27 07:50:03	2023-10-27 07:50:03	111	6	33
205	170	border_crossing	2023-10-27 07:50:06	2023-10-27 07:50:06	111	7	33
206	170	custom_clearance	2023-10-27 07:50:09	2023-10-27 07:50:09	111	8	33
207	170	delivered	2023-10-27 07:50:19	2023-10-27 07:50:19	111	9	33
208	172	request_created	2023-11-07 11:10:19	2023-11-07 11:10:19	107	0	34
209	172	accepted	2023-11-07 07:16:32	2023-11-07 11:10:19	107	2	34
210	172	journey_started	2023-11-07 07:17:07	2023-11-07 07:17:07	107	4	34
211	172	item_collected	2023-11-07 07:17:21	2023-11-07 07:17:21	107	5	34
212	172	on_the_way	2023-11-07 07:17:59	2023-11-07 07:17:59	107	6	34
213	172	border_crossing	2023-11-07 07:18:05	2023-11-07 07:18:05	107	7	34
214	172	custom_clearance	2023-11-07 07:18:15	2023-11-07 07:18:15	107	8	34
215	172	delivered	2023-11-07 07:19:06	2023-11-07 07:19:06	107	9	34
216	177	request_created	2023-11-09 17:44:45	2023-11-09 17:44:45	65	0	0
217	178	request_created	2023-11-10 07:57:10	2023-11-10 07:57:10	97	0	0
218	181	request_created	2023-11-10 16:30:03	2023-11-10 16:30:03	83	0	35
219	181	accepted	2023-11-10 12:34:29	2023-11-10 16:30:03	83	2	35
220	219	request_created	2023-11-13 14:56:24	2023-11-13 14:56:24	139	0	37
221	219	accepted	2023-11-13 11:05:36	2023-11-13 14:56:24	139	2	37
222	222	request_created	2023-11-13 15:24:06	2023-11-13 15:24:06	37	0	38
223	222	accepted	2023-11-13 11:30:09	2023-11-13 15:24:06	37	2	38
224	222	request_created	2023-11-13 15:24:06	2023-11-13 15:24:06	139	0	39
225	222	accepted	2023-11-13 11:30:25	2023-11-13 15:24:06	139	2	39
226	223	request_created	2023-11-13 15:47:56	2023-11-13 15:47:56	132	0	40
227	223	accepted	2023-11-13 12:14:09	2023-11-13 15:47:56	132	2	40
228	181	border_crossing	2023-11-13 12:25:48	2023-11-13 12:25:48	83	7	35
229	181	custom_clearance	2023-11-13 12:26:09	2023-11-13 12:26:09	83	8	35
230	181	delivered	2023-11-13 12:26:45	2023-11-13 12:26:45	83	9	35
231	81	request_created	2023-10-11 09:11:09	2023-10-11 09:11:09	83	0	41
232	81	accepted	2023-11-13 13:33:21	2023-10-11 09:11:09	83	2	41
233	225	request_created	2023-11-13 18:32:21	2023-11-13 18:32:21	132	0	42
234	225	accepted	2023-11-13 14:38:32	2023-11-13 18:32:21	132	2	42
235	226	request_created	2023-11-13 22:23:37	2023-11-13 22:23:37	83	0	43
236	226	accepted	2023-11-14 05:44:42	2023-11-13 22:23:37	83	2	43
237	226	journey_started	2023-11-14 05:44:59	2023-11-14 05:44:59	83	4	43
238	232	request_created	2023-11-14 09:54:39	2023-11-14 09:54:39	139	0	44
239	232	accepted	2023-11-14 05:59:31	2023-11-14 09:54:39	139	2	44
240	232	journey_started	2023-11-14 06:00:09	2023-11-14 06:00:09	139	4	44
241	232	item_collected	2023-11-14 06:00:35	2023-11-14 06:00:35	139	5	44
242	232	on_the_way	2023-11-14 06:00:38	2023-11-14 06:00:38	139	6	44
243	232	border_crossing	2023-11-14 06:00:40	2023-11-14 06:00:40	139	7	44
244	232	custom_clearance	2023-11-14 06:00:43	2023-11-14 06:00:43	139	8	44
245	232	delivered	2023-11-14 06:01:33	2023-11-14 06:01:33	139	9	44
246	204	request_created	2023-11-13 14:04:06	2023-11-13 14:04:06	97	0	45
247	204	accepted	2023-11-14 07:18:08	2023-11-13 14:04:06	97	2	45
248	204	journey_started	2023-11-14 07:18:32	2023-11-14 07:18:32	97	4	45
249	204	item_collected	2023-11-14 07:20:49	2023-11-14 07:20:49	97	5	45
250	204	on_the_way	2023-11-14 07:20:53	2023-11-14 07:20:53	97	6	45
251	204	border_crossing	2023-11-14 07:20:55	2023-11-14 07:20:55	97	7	45
252	204	custom_clearance	2023-11-14 07:20:57	2023-11-14 07:20:57	97	8	45
256	226	border_crossing	2023-11-14 07:27:42	2023-11-14 07:27:42	83	7	43
257	226	custom_clearance	2023-11-14 07:27:44	2023-11-14 07:27:44	83	8	43
258	226	delivered	2023-11-14 07:27:53	2023-11-14 07:27:53	83	9	43
253	204	delivered	2023-11-14 07:24:11	2023-11-14 07:24:11	97	9	45
254	226	item_collected	2023-11-14 07:27:39	2023-11-14 07:27:39	83	5	43
255	226	on_the_way	2023-11-14 07:27:40	2023-11-14 07:27:40	83	6	43
\.


--
-- Data for Name: booking_truck_alots; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_truck_alots (id, booking_truck_id, user_id, role_id, created_at, updated_at) FROM stdin;
1	66	83	2	2023-10-11 09:27:58	2023-10-11 09:27:58
2	67	69	2	2023-10-16 15:31:02	2023-10-16 15:31:02
3	68	69	2	2023-10-16 15:58:23	2023-10-16 15:58:23
4	69	69	2	2023-10-16 16:04:21	2023-10-16 16:04:21
5	71	83	2	2023-10-16 16:30:06	2023-10-16 16:30:06
6	77	83	2	2023-10-17 10:48:22	2023-10-17 10:48:22
7	82	71	2	2023-10-17 12:43:12	2023-10-17 12:43:12
8	81	83	2	2023-10-17 12:45:28	2023-10-17 12:45:28
9	83	83	2	2023-10-17 13:28:37	2023-10-17 13:28:37
10	85	83	2	2023-10-17 15:07:45	2023-10-17 15:07:45
11	86	83	2	2023-10-17 15:17:56	2023-10-17 15:17:56
12	80	83	2	2023-10-18 08:48:46	2023-10-18 08:48:46
13	78	83	2	2023-10-18 08:51:16	2023-10-18 08:51:16
14	87	83	2	2023-10-18 08:53:12	2023-10-18 08:53:12
15	65	83	2	2023-10-18 09:06:22	2023-10-18 09:06:22
16	89	83	2	2023-10-18 12:27:53	2023-10-18 12:27:53
17	90	83	2	2023-10-18 12:31:54	2023-10-18 12:31:54
18	91	83	2	2023-10-18 12:33:18	2023-10-18 12:33:18
19	92	83	2	2023-10-18 12:45:35	2023-10-18 12:45:35
20	58	83	2	2023-10-18 12:50:44	2023-10-18 12:50:44
21	93	86	2	2023-10-18 17:27:30	2023-10-18 17:27:30
22	55	83	2	2023-10-18 22:12:59	2023-10-18 22:12:59
23	57	83	2	2023-10-18 22:13:38	2023-10-18 22:13:38
24	84	83	2	2023-10-18 22:15:20	2023-10-18 22:15:20
25	85	87	2	2023-10-19 12:33:36	2023-10-19 12:33:36
26	93	88	2	2023-10-19 12:39:19	2023-10-19 12:39:19
27	94	83	2	2023-10-20 13:11:15	2023-10-20 13:11:15
28	95	83	2	2023-10-20 15:48:21	2023-10-20 15:48:21
29	95	98	2	2023-10-20 15:48:25	2023-10-20 15:48:25
30	96	97	2	2023-10-20 15:48:28	2023-10-20 15:48:28
31	97	88	2	2023-10-20 15:48:32	2023-10-20 15:48:32
32	98	61	2	2023-10-20 17:01:38	2023-10-20 17:01:38
33	98	88	2	2023-10-20 17:02:02	2023-10-20 17:02:02
34	99	90	2	2023-10-24 11:22:24	2023-10-24 11:22:24
35	100	97	2	2023-10-24 11:22:28	2023-10-24 11:22:28
36	101	90	2	2023-10-24 11:35:59	2023-10-24 11:35:59
37	102	97	2	2023-10-24 11:36:03	2023-10-24 11:36:03
38	104	90	2	2023-10-24 12:08:44	2023-10-24 12:08:44
39	105	97	2	2023-10-24 12:08:48	2023-10-24 12:08:48
40	106	90	2	2023-10-24 12:15:35	2023-10-24 12:15:35
41	107	97	2	2023-10-24 12:15:39	2023-10-24 12:15:39
42	108	92	2	2023-10-24 14:51:06	2023-10-24 14:51:06
43	109	97	2	2023-10-24 14:51:09	2023-10-24 14:51:09
44	110	98	2	2023-10-24 16:40:59	2023-10-24 16:40:59
45	114	98	2	2023-10-25 10:31:59	2023-10-25 10:31:59
46	126	61	2	2023-10-26 10:51:10	2023-10-26 10:51:10
47	127	86	2	2023-10-26 10:53:51	2023-10-26 10:53:51
48	128	37	2	2023-10-26 11:25:07	2023-10-26 11:25:07
49	128	65	2	2023-10-26 11:25:07	2023-10-26 11:25:07
50	128	59	2	2023-10-26 11:25:07	2023-10-26 11:25:07
51	128	66	2	2023-10-26 11:25:07	2023-10-26 11:25:07
52	129	86	2	2023-10-26 11:41:11	2023-10-26 11:41:11
53	130	66	2	2023-10-26 12:36:47	2023-10-26 12:36:47
54	131	64	2	2023-10-26 12:43:38	2023-10-26 12:43:38
55	132	65	2	2023-10-26 14:50:13	2023-10-26 14:50:13
56	134	86	2	2023-10-26 15:16:39	2023-10-26 15:16:39
57	141	97	2	2023-10-26 15:31:44	2023-10-26 15:31:44
58	142	86	2	2023-10-26 15:35:40	2023-10-26 15:35:40
59	146	86	2	2023-10-26 15:51:12	2023-10-26 15:51:12
60	146	88	2	2023-10-26 15:51:15	2023-10-26 15:51:15
61	146	107	2	2023-10-26 15:51:19	2023-10-26 15:51:19
62	149	86	2	2023-10-26 17:54:23	2023-10-26 17:54:23
63	149	88	2	2023-10-26 17:54:27	2023-10-26 17:54:27
64	150	86	2	2023-10-27 09:32:48	2023-10-27 09:32:48
65	151	111	2	2023-10-27 09:32:52	2023-10-27 09:32:52
66	154	86	2	2023-10-27 10:04:16	2023-10-27 10:04:16
67	159	114	2	2023-10-27 11:40:11	2023-10-27 11:40:11
68	160	111	2	2023-10-27 11:40:14	2023-10-27 11:40:14
69	161	58	2	2023-11-01 13:44:53	2023-11-01 13:44:53
70	161	59	2	2023-11-01 13:44:56	2023-11-01 13:44:56
71	161	64	2	2023-11-01 13:44:59	2023-11-01 13:44:59
72	158	59	2	2023-11-07 10:55:41	2023-11-07 10:55:41
73	158	61	2	2023-11-07 10:55:45	2023-11-07 10:55:45
74	158	65	2	2023-11-07 10:55:47	2023-11-07 10:55:47
75	162	107	2	2023-11-07 11:12:12	2023-11-07 11:12:12
76	162	114	2	2023-11-07 11:12:15	2023-11-07 11:12:15
77	166	65	2	2023-11-09 17:44:45	2023-11-09 17:44:45
78	167	97	2	2023-11-10 07:57:10	2023-11-10 07:57:10
79	169	83	2	2023-11-10 16:30:33	2023-11-10 16:30:33
80	188	139	2	2023-11-13 14:57:59	2023-11-13 14:57:59
81	188	139	2	2023-11-13 14:58:07	2023-11-13 14:58:07
82	191	139	2	2023-11-13 15:25:04	2023-11-13 15:25:04
83	191	37	2	2023-11-13 15:27:37	2023-11-13 15:27:37
84	191	132	2	2023-11-13 15:41:54	2023-11-13 15:41:54
85	192	132	2	2023-11-13 15:51:56	2023-11-13 15:51:56
86	192	58	2	2023-11-13 15:57:21	2023-11-13 15:57:21
87	192	37	2	2023-11-13 16:45:46	2023-11-13 16:45:46
88	192	61	2	2023-11-13 16:46:38	2023-11-13 16:46:38
89	192	61	2	2023-11-13 16:47:20	2023-11-13 16:47:20
90	192	64	2	2023-11-13 16:47:36	2023-11-13 16:47:36
91	194	132	2	2023-11-13 18:33:31	2023-11-13 18:33:31
92	192	97	2	2023-11-13 18:55:06	2023-11-13 18:55:06
93	192	97	2	2023-11-13 18:57:42	2023-11-13 18:57:42
94	192	97	2	2023-11-13 19:04:22	2023-11-13 19:04:22
95	192	97	2	2023-11-13 19:10:12	2023-11-13 19:10:12
96	195	83	2	2023-11-14 09:41:14	2023-11-14 09:41:14
97	197	139	2	2023-11-14 09:56:21	2023-11-14 09:56:21
98	185	97	2	2023-11-14 11:14:00	2023-11-14 11:14:00
99	198	111	2	2023-11-14 11:46:39	2023-11-14 11:46:39
100	199	37	2	2023-11-14 13:01:13	2023-11-14 13:01:13
\.


--
-- Data for Name: booking_truck_carts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_truck_carts (id, booking_cart_id, truck_id, quantity, gross_weight, created_at, updated_at) FROM stdin;
215	273	3	2	55	2023-11-13 16:58:00	2023-11-13 16:58:00
136	151	2	2	2tons	2023-11-12 15:57:19	2023-11-12 15:57:19
237	310	2	12	13	2023-11-14 11:11:41	2023-11-14 11:11:41
\.


--
-- Data for Name: booking_trucks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_trucks (id, booking_id, truck_id, quantity, gross_weight, created_at, updated_at) FROM stdin;
44	54	2	1	10 KG	2023-08-26 15:24:39	2023-08-26 15:24:39
45	55	2	50	590	2023-08-26 20:33:03	2023-08-26 20:33:03
46	56	3	100	600	2023-08-26 20:38:12	2023-08-26 20:38:12
47	57	2	25	66	2023-09-04 12:08:39	2023-09-04 12:08:39
48	58	3	3	33 kg	2023-10-07 13:44:06	2023-10-07 13:44:06
49	59	3	3	33 kg	2023-10-07 13:44:49	2023-10-07 13:44:49
50	60	2	1	1 kg	2023-10-07 13:47:17	2023-10-07 13:47:17
51	61	2	1	1 kg	2023-10-07 13:47:33	2023-10-07 13:47:33
52	62	2	1	1 kg	2023-10-07 13:47:49	2023-10-07 13:47:49
53	63	2	1	1 kg	2023-10-07 13:48:45	2023-10-07 13:48:45
54	64	3	1	1 kg	2023-10-07 13:51:24	2023-10-07 13:51:24
55	65	1	2	1kg	2023-10-07 14:00:38	2023-10-07 14:00:38
56	66	2	1	1 kg	2023-10-07 16:09:00	2023-10-07 16:09:00
57	67	1	22	23 kg	2023-10-07 16:24:13	2023-10-07 16:24:13
58	68	1	250	34	2023-10-07 17:50:52	2023-10-07 17:50:52
59	69	2	250	100	2023-10-07 17:52:24	2023-10-07 17:52:24
60	72	3	250	12	2023-10-09 17:11:04	2023-10-09 17:11:04
61	74	3	1	20	2023-10-09 17:24:45	2023-10-09 17:24:45
62	75	3	2	34	2023-10-09 17:32:59	2023-10-09 17:32:59
63	78	3	1	20	2023-10-10 17:18:08	2023-10-10 17:18:08
64	79	3	2	30	2023-10-10 17:21:28	2023-10-10 17:21:28
65	80	1	2	39	2023-10-11 00:17:54	2023-10-11 00:17:54
66	81	1	1	20	2023-10-11 09:11:09	2023-10-11 09:11:09
67	82	2	2	29	2023-10-16 14:50:04	2023-10-16 14:50:04
68	83	2	1	10 KG	2023-10-16 15:57:48	2023-10-16 15:57:48
69	84	2	1	10 KG	2023-10-16 16:03:48	2023-10-16 16:03:48
70	85	2	1	10 KG	2023-10-16 16:17:37	2023-10-16 16:17:37
71	86	1	1	10 KG	2023-10-16 16:29:22	2023-10-16 16:29:22
72	87	1	1	10 KG	2023-10-16 17:08:18	2023-10-16 17:08:18
73	88	1	1	10 KG	2023-10-16 17:11:31	2023-10-16 17:11:31
74	90	2	2	10	2023-10-16 17:17:20	2023-10-16 17:17:20
75	92	2	2	20	2023-10-17 09:08:51	2023-10-17 09:08:51
76	93	2	2	25	2023-10-17 09:14:45	2023-10-17 09:14:45
77	94	1	2	29	2023-10-17 10:47:21	2023-10-17 10:47:21
78	95	1	10	100	2023-10-17 11:35:01	2023-10-17 11:35:01
79	96	2	10	100 kg	2023-10-17 11:43:21	2023-10-17 11:43:21
80	97	1	1	10 KG	2023-10-17 11:46:24	2023-10-17 11:46:24
81	98	1	1	10 KG	2023-10-17 11:46:59	2023-10-17 11:46:59
82	99	2	10	100 kg	2023-10-17 12:04:06	2023-10-17 12:04:06
83	100	1	11	110	2023-10-17 13:27:58	2023-10-17 13:27:58
84	101	1	1	10 KG	2023-10-17 15:02:30	2023-10-17 15:02:30
85	91	1	45	2x3x4	2023-10-17 15:07:45	2023-10-17 15:07:45
86	102	1	10	100	2023-10-17 15:17:05	2023-10-17 15:17:05
87	89	1	5	54	2023-10-18 08:53:12	2023-10-18 08:53:12
88	103	1	10	100 kg	2023-10-18 10:03:58	2023-10-18 10:03:58
89	76	1	13	34	2023-10-18 12:27:53	2023-10-18 12:27:53
90	73	1	3	34	2023-10-18 12:31:54	2023-10-18 12:31:54
91	71	1	21	33	2023-10-18 12:33:18	2023-10-18 12:33:18
92	70	1	80	34	2023-10-18 12:45:35	2023-10-18 12:45:35
93	104	2	30	15	2023-10-18 16:28:07	2023-10-18 16:28:07
94	105	1	1	12	2023-10-20 13:11:15	2023-10-20 13:11:15
95	106	1	2	250	2023-10-20 15:42:41	2023-10-20 15:42:41
96	106	3	1	250	2023-10-20 15:42:41	2023-10-20 15:42:41
97	106	2	2	250	2023-10-20 15:42:41	2023-10-20 15:42:41
98	108	2	250	24	2023-10-20 17:01:38	2023-10-20 17:01:38
99	111	2	10	100	2023-10-24 11:21:33	2023-10-24 11:21:33
100	111	3	15	50	2023-10-24 11:21:33	2023-10-24 11:21:33
101	112	2	10	40	2023-10-24 11:35:07	2023-10-24 11:35:07
102	112	3	15	50	2023-10-24 11:35:07	2023-10-24 11:35:07
103	113	3	5	45	2023-10-24 11:38:30	2023-10-24 11:38:30
104	114	2	5	50kg	2023-10-24 11:51:13	2023-10-24 11:51:13
105	114	3	10	100	2023-10-24 11:51:13	2023-10-24 11:51:13
106	115	2	10	100	2023-10-24 12:11:37	2023-10-24 12:11:37
107	115	3	50	50	2023-10-24 12:11:37	2023-10-24 12:11:37
108	116	2	2	100	2023-10-24 14:47:56	2023-10-24 14:47:56
109	116	3	2	45	2023-10-24 14:47:56	2023-10-24 14:47:56
110	118	1	1	10 KG	2023-10-24 15:18:46	2023-10-24 15:18:46
111	119	3	12	90	2023-10-24 17:00:17	2023-10-24 17:00:17
112	119	2	12	120	2023-10-24 17:00:17	2023-10-24 17:00:17
113	119	1	12	90	2023-10-24 17:00:17	2023-10-24 17:00:17
114	120	1	24	24	2023-10-25 10:31:59	2023-10-25 10:31:59
115	122	3	2	44	2023-10-25 16:14:22	2023-10-25 16:14:22
116	122	4	1	99	2023-10-25 16:14:22	2023-10-25 16:14:22
117	122	2	1	21	2023-10-25 16:14:22	2023-10-25 16:14:22
118	122	1	1	22	2023-10-25 16:14:22	2023-10-25 16:14:22
119	124	2	2	250	2023-10-26 09:57:27	2023-10-26 09:57:27
120	125	1	10	100 kg	2023-10-26 09:58:46	2023-10-26 09:58:46
121	126	1	10	100 kg	2023-10-26 10:02:54	2023-10-26 10:02:54
122	127	2	2	250	2023-10-26 10:08:31	2023-10-26 10:08:31
123	128	2	1	10	2023-10-26 10:28:00	2023-10-26 10:28:00
124	128	2	2	20	2023-10-26 10:28:00	2023-10-26 10:28:00
125	129	2	2	250	2023-10-26 10:28:43	2023-10-26 10:28:43
126	131	2	1	10	2023-10-26 10:51:10	2023-10-26 10:51:10
127	130	2	2	240	2023-10-26 10:53:51	2023-10-26 10:53:51
128	132	2	5	10	2023-10-26 11:25:07	2023-10-26 11:25:07
129	135	2	2	24	2023-10-26 11:41:11	2023-10-26 11:41:11
130	139	2	1	10	2023-10-26 12:36:47	2023-10-26 12:36:47
131	140	2	1	12	2023-10-26 12:43:38	2023-10-26 12:43:38
132	138	2	1	10	2023-10-26 14:50:13	2023-10-26 14:50:13
133	141	3	1	250	2023-10-26 15:00:33	2023-10-26 15:00:33
134	142	2	25	26	2023-10-26 15:16:39	2023-10-26 15:16:39
135	143	1	1	10 KG	2023-10-26 15:19:12	2023-10-26 15:19:12
136	143	2	1	10 KG	2023-10-26 15:19:12	2023-10-26 15:19:12
137	143	3	1	10 KG	2023-10-26 15:19:12	2023-10-26 15:19:12
138	145	1	1	66	2023-10-26 15:27:03	2023-10-26 15:27:03
139	145	3	3	12	2023-10-26 15:27:03	2023-10-26 15:27:03
140	145	2	1	21	2023-10-26 15:27:03	2023-10-26 15:27:03
141	146	3	2	22	2023-10-26 15:28:33	2023-10-26 15:28:33
142	146	2	2	22	2023-10-26 15:35:40	2023-10-26 15:35:40
143	147	1	2	67	2023-10-26 15:40:14	2023-10-26 15:40:14
144	148	3	3	56	2023-10-26 15:41:52	2023-10-26 15:41:52
145	148	4	3	66	2023-10-26 15:41:52	2023-10-26 15:41:52
146	149	2	3	33	2023-10-26 15:46:35	2023-10-26 15:46:35
147	150	4	10	100 kg	2023-10-26 16:38:25	2023-10-26 16:38:25
148	152	5	1	25	2023-10-26 16:40:46	2023-10-26 16:40:46
149	153	2	2	25	2023-10-26 17:12:44	2023-10-26 17:12:44
150	158	2	1	250	2023-10-27 09:13:45	2023-10-27 09:13:45
151	158	3	1	250	2023-10-27 09:13:45	2023-10-27 09:13:45
152	159	4	1	25	2023-10-27 09:51:14	2023-10-27 09:51:14
153	160	6	1	250	2023-10-27 09:52:03	2023-10-27 09:52:03
154	161	2	1	25	2023-10-27 10:04:16	2023-10-27 10:04:16
155	162	4	10	100 kg	2023-10-27 10:11:52	2023-10-27 10:11:52
156	164	4	2	66	2023-10-27 10:22:59	2023-10-27 10:22:59
157	166	5	3	99	2023-10-27 10:29:15	2023-10-27 10:29:15
158	167	2	3	77	2023-10-27 10:46:08	2023-10-27 10:46:08
159	170	2	1	25	2023-10-27 11:16:13	2023-10-27 11:16:13
160	170	3	1	4	2023-10-27 11:16:13	2023-10-27 11:16:13
161	169	2	1	23	2023-11-01 13:44:53	2023-11-01 13:44:53
162	172	2	2	1	2023-11-07 11:10:19	2023-11-07 11:10:19
163	173	3	2	12	2023-11-09 11:09:37	2023-11-09 11:09:37
164	175	1	1	10	2023-11-09 12:41:13	2023-11-09 12:41:13
165	176	1	1	10	2023-11-09 12:42:48	2023-11-09 12:42:48
166	177	2	100	1111	2023-11-09 17:44:45	2023-11-09 17:44:45
167	178	3	10	111	2023-11-10 07:57:10	2023-11-10 07:57:10
168	180	2	12	25	2023-11-10 16:27:26	2023-11-10 16:27:26
169	181	1	12	32	2023-11-10 16:30:03	2023-11-10 16:30:03
170	182	1	12	21	2023-11-10 16:48:56	2023-11-10 16:48:56
171	183	2	2	500	2023-11-13 09:54:35	2023-11-13 09:54:35
172	184	1	20	2	2023-11-13 10:04:42	2023-11-13 10:04:42
173	185	1	12	2	2023-11-13 10:08:50	2023-11-13 10:08:50
174	188	1	2	1	2023-11-13 10:16:41	2023-11-13 10:16:41
175	189	1	2	1	2023-11-13 10:20:52	2023-11-13 10:20:52
176	190	3	2222	600@	2023-11-13 10:24:45	2023-11-13 10:24:45
177	193	2	1	10 KG	2023-11-13 10:44:10	2023-11-13 10:44:10
178	195	1	2	2	2023-11-13 11:38:16	2023-11-13 11:38:16
179	196	2	0	00	2023-11-13 11:49:22	2023-11-13 11:49:22
180	197	5	5556	ffggg	2023-11-13 13:35:37	2023-11-13 13:35:37
181	199	1	9	3	2023-11-13 13:46:59	2023-11-13 13:46:59
182	199	3	4	8	2023-11-13 13:46:59	2023-11-13 13:46:59
183	201	5	2	4555	2023-11-13 13:56:05	2023-11-13 13:56:05
184	203	2	2	55	2023-11-13 13:56:54	2023-11-13 13:56:54
185	204	2	6	5	2023-11-13 14:04:06	2023-11-13 14:04:06
186	204	1	7	7	2023-11-13 14:04:06	2023-11-13 14:04:06
187	217	7	2	3	2023-11-13 14:29:25	2023-11-13 14:29:25
188	219	2	2	34	2023-11-13 14:56:24	2023-11-13 14:56:24
189	220	2	2	rtt	2023-11-13 14:58:09	2023-11-13 14:58:09
190	221	3	2	55	2023-11-13 15:18:15	2023-11-13 15:18:15
191	222	2	2	55	2023-11-13 15:24:06	2023-11-13 15:24:06
192	223	2	2	55	2023-11-13 15:47:56	2023-11-13 15:47:56
193	224	2	122222	55888888	2023-11-13 16:51:52	2023-11-13 16:51:52
194	225	2	2	55	2023-11-13 18:32:21	2023-11-13 18:32:21
195	226	1	2	5	2023-11-13 22:23:37	2023-11-13 22:23:37
196	229	7	2	5	2023-11-13 23:10:22	2023-11-13 23:10:22
197	232	2	1	50	2023-11-14 09:56:21	2023-11-14 09:56:21
198	233	3	44	44	2023-11-14 11:46:39	2023-11-14 11:46:39
199	234	2	2	5000	2023-11-14 12:57:29	2023-11-14 12:57:29
200	235	3	2	3	2023-11-14 13:04:57	2023-11-14 13:04:57
201	235	2	3	2	2023-11-14 13:04:57	2023-11-14 13:04:57
202	236	2	2	55	2023-11-14 13:09:56	2023-11-14 13:09:56
203	236	3	3	88	2023-11-14 13:09:56	2023-11-14 13:09:56
204	236	1	1	32	2023-11-14 13:09:56	2023-11-14 13:09:56
205	237	2	2	55	2023-11-14 13:10:22	2023-11-14 13:10:22
206	237	3	3	44	2023-11-14 13:10:22	2023-11-14 13:10:22
207	238	3	3	55	2023-11-14 13:10:55	2023-11-14 13:10:55
208	239	1	1	1	2023-11-14 13:11:14	2023-11-14 13:11:14
\.


--
-- Data for Name: bookings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.bookings (id, is_collection, collection_address, deliver_address, sender_id, deligate_id, deligate_type, admin_response, comission_amount, customer_signature, delivery_note, status, created_at, updated_at, booking_number, is_paid, invoice_number, total_commission_amount, total_received_amount, sub_total, grand_total, shipping_method_id, total_qoutation_amount, collection_latitude, collection_longitude, collection_country, collection_city, collection_zipcode, deliver_latitude, deliver_longitude, deliver_country, deliver_city, deliver_zipcode, collection_phone, deliver_phone, statuscode, parent_id, collection_address_id, deliver_address_id) FROM stdin;
54	1	Building Materials Mall	Trade Centre	67	1	ftl	pending	\N	0	\N	pending	2023-08-26 15:24:39	2023-08-26 15:24:39	#TX-000054	no	\N	\N	0	\N	\N	\N	0	25.16533880130602	55.46189738501064	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N			0	0	0	0
55	1	Trade Centre	Premier Inn Dubai Dragon Mart Hotel	44	1	ftl	pending	\N	0	\N	pending	2023-08-26 20:33:03	2023-08-26 20:33:03	#TX-000055	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.179631823378383	55.42361689867244	United Arab Emirates	Dubai	\N			0	0	0	0
56	1	Trade Centre	Premier Inn Dubai Dragon Mart Hotel	44	1	ftl	pending	\N	0	\N	pending	2023-08-26 20:38:12	2023-08-26 20:38:12	#TX-000056	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.179631823378383	55.42361689867244	United Arab Emirates	Dubai	\N			0	0	0	0
57	1	Business Bay - Dubai - United Arab Emirates	Business Bay - Dubai - United Arab Emirates	70	1	ftl	pending	\N	0	\N	pending	2023-09-04 12:08:39	2023-09-04 12:08:39	#TX-000057	no	\N	\N	0	\N	\N	\N	0	25.183164700000003	55.272887	United Arab Emirates	Dubai	\N	25.183164700000003	55.272887	United Arab Emirates	Dubai	\N	+971 5248866658	+971 5248866658	0	0	0	0
58	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan	73	1	ftl	pending	\N	0	\N	pending	2023-10-07 13:44:06	2023-10-07 13:44:06	#TX-000058	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.5165256	73.1108949	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
59	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan	73	1	ftl	pending	\N	0	\N	pending	2023-10-07 13:44:49	2023-10-07 13:44:49	#TX-000059	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.5165256	73.1108949	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
60	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	73	1	ftl	pending	\N	0	\N	pending	2023-10-07 13:47:17	2023-10-07 13:47:17	#TX-000060	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.5707966	73.145327	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
61	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	73	1	ftl	pending	\N	0	\N	pending	2023-10-07 13:47:33	2023-10-07 13:47:33	#TX-000061	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.5707966	73.145327	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
62	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	73	1	ftl	pending	\N	0	\N	pending	2023-10-07 13:47:49	2023-10-07 13:47:49	#TX-000062	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.5707966	73.145327	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
63	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	73	1	ftl	pending	\N	0	\N	pending	2023-10-07 13:48:45	2023-10-07 13:48:45	#TX-000063	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.5707966	73.145327	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
64	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan	73	1	ftl	pending	\N	0	\N	pending	2023-10-07 13:51:24	2023-10-07 13:51:24	#TX-000064	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.5165256	73.1108949	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
66	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan	73	1	ftl	pending	\N	0	\N	pending	2023-10-07 16:09:00	2023-10-07 16:09:00	#TX-000066	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.5165256	73.1108949	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
65	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan	73	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-07 14:00:38	2023-10-18 22:12:59	#TX-000065	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.5165256	73.1108949	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
69	1	Zayed City - Abu Dhabi - United Arab Emirates	Zayed City - Abu Dhabi - United Arab Emirates	75	1	ftl	pending	\N	0	\N	pending	2023-10-07 17:52:24	2023-10-07 17:52:24	#TX-000069	no	\N	\N	0	\N	\N	\N	0	23.656830600000003	53.7033803	United Arab Emirates	Dubai	\N	23.656830600000003	53.7033803	United Arab Emirates	Dubai	\N	+971 55424884664	+971 55424884664	0	0	0	0
68	1	Zayed City - Abu Dhabi - United Arab Emirates	Zayed City - Abu Dhabi - United Arab Emirates	75	1	ftl	approved_by_admin	\N	0	\N	qoutes_received	2023-10-07 17:50:52	2023-10-18 12:52:13	#TX-000068	no	\N	\N	0	\N	\N	\N	0	23.656830600000003	53.7033803	United Arab Emirates	Dubai	\N	23.656830600000003	53.7033803	United Arab Emirates	Dubai	\N	+971 55424884664	+971 55424884664	1	0	0	0
70	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan	73	1	ltl	ask_for_qoute	\N	0	\N	pending	2023-10-09 10:25:10	2023-10-18 12:45:35	#TX-000070	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	\N	\N	33.5165256	73.1108949	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
90	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-10-16 17:17:20	2023-10-16 17:17:20	#TX-000090	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
72	1	238 Second Industrial St - Industrial Area_5 - Industrial Area - Sharjah - United Arab Emirates,	238 Second Industrial St - Industrial Area_5 - Industrial Area - Sharjah - United Arab Emirates,	78	1	ftl	pending	\N	0	\N	pending	2023-10-09 17:11:04	2023-10-09 17:11:04	#TX-000072	no	\N	\N	0	\N	\N	\N	0	25.33090601907928	55.42093623429537	United Arab Emirates	Dubai	\N	25.33090601907928	55.42093623429537	United Arab Emirates	Dubai	\N	+971 554251884	+971 554251884	0	0	0	0
74	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	73	1	ftl	pending	\N	0	\N	pending	2023-10-09 17:24:45	2023-10-09 17:24:45	#TX-000074	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
75	1	H48P+VP6, Main Main PWD Rd, Block C Police Foundation, Rawalpindi, Punjab, Pakistan,	H48P+VP6, Main Main PWD Rd, Block C Police Foundation, Rawalpindi, Punjab, Pakistan,	77	1	ftl	pending	\N	0	\N	pending	2023-10-09 17:32:59	2023-10-09 17:32:59	#TX-000075	no	\N	\N	0	\N	\N	\N	0	33.56705063528734	73.13677925616503	United Arab Emirates	Dubai	\N	33.56705063528734	73.13677925616503	United Arab Emirates	Dubai	\N	+971 1470852369	+971 1470852369	0	0	0	0
73	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	73	1	ltl	ask_for_qoute	\N	0	\N	pending	2023-10-09 17:23:34	2023-10-18 12:31:54	#TX-000073	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	\N	\N	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
77	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	73	1	ltl	pending	\N	0	\N	pending	2023-10-10 17:16:50	2023-10-10 17:16:50	#TX-000077	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	\N	\N	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
78	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	73	1	ftl	pending	\N	0	\N	pending	2023-10-10 17:18:08	2023-10-10 17:18:08	#TX-000078	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
79	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	82	1	ftl	pending	\N	0	\N	pending	2023-10-10 17:21:28	2023-10-10 17:21:28	#TX-000079	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
81	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	approved_by_admin	\N	0	\N	on_process	2023-10-11 09:11:09	2023-11-13 17:33:21	#TX-000081	no	\N	0	0	300	300	\N	300	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	2	0	0	0
84	1	Trade Centre	Umm Al Quain	74	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-16 16:03:48	2023-10-18 10:23:45	#TX-000084	no	\N	30	0	330	330	\N	300	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	4	0	0	0
82	1	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	673C+W8M - Dubai - United Arab Emirates,	73	1	ftl	approved_by_admin	\N	0	\N	qoutes_received	2023-10-16 14:50:04	2023-10-16 15:40:02	#TX-000082	no	\N	10	0	0	0	\N	0	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
83	1	Trade Centre	Umm Al Quain	74	1	ftl	approved_by_admin	\N	0	\N	qoutes_received	2023-10-16 15:57:48	2023-10-16 16:01:30	#TX-000083	no	\N	10	0	0	0	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
85	1	Trade Centre	Umm Al Quain	74	1	ftl	pending	\N	0	\N	pending	2023-10-16 16:17:37	2023-10-16 16:17:37	#TX-000085	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
86	1	Trade Centre	Umm Al Quain	74	1	ftl	approved_by_admin	\N	0	\N	qoutes_received	2023-10-16 16:29:22	2023-10-16 16:31:46	#TX-000086	no	\N	10	0	0	0	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
76	1	H48P+VP6, Main Main PWD Rd, Block C Police Foundation, Rawalpindi, Punjab, Pakistan,	H48P+VP6, Main Main PWD Rd, Block C Police Foundation, Rawalpindi, Punjab, Pakistan,	77	1	ltl	ask_for_qoute	\N	0	\N	pending	2023-10-09 17:33:44	2023-10-18 12:27:53	#TX-000076	no	\N	\N	0	\N	\N	\N	0	33.56705063528734	73.13677925616503	United Arab Emirates	\N	\N	33.56705063528734	73.13677925616503	United Arab Emirates	Dubai	\N	+971 1470852369	+971 1470852369	0	0	0	0
87	1	Trade Centre	Umm Al Quain	74	1	ftl	pending	\N	0	\N	pending	2023-10-16 17:08:18	2023-10-16 17:08:18	#TX-000087	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
88	1	Trade Centre	Umm Al Quain	74	1	ftl	pending	\N	0	\N	pending	2023-10-16 17:11:31	2023-10-16 17:11:31	#TX-000088	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
80	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	73	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-11 00:17:54	2023-10-18 09:06:22	#TX-000080	yes	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
89	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ltl	ask_for_qoute	\N	0	\N	pending	2023-10-16 17:16:20	2023-10-18 08:53:12	#TX-000089	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
92	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-10-17 09:08:51	2023-10-17 09:08:51	#TX-000092	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
93	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-10-17 09:14:45	2023-10-17 09:14:45	#TX-000093	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
106	1	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	85	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-20 15:42:41	2023-10-20 16:45:06	#TX-000106	yes	\N	159.95	1400	1442.95	1442.95	\N	1283	25.047127821877247	55.15551958233118	United Arab Emirates	Dubai	\N	25.184237262438835	55.259992964565754	United Arab Emirates	Dubai	\N	+971 552125893	+971 552125893	4	0	0	0
98	1	Trade Centre	Umm Al Quain	74	1	ftl	approved_by_admin	\N	0	\N	qoutes_received	2023-10-17 11:46:59	2023-10-17 12:49:35	#TX-000098	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	1	0	0	0
96	1	Umm Al Quain	Trade Centre	74	1	ftl	pending	\N	0	\N	pending	2023-10-17 11:43:21	2023-10-17 11:43:21	#TX-000096	no	\N	\N	0	\N	\N	\N	0	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
103	1	Trade Centre	Trade Centre	74	3	ftl	pending	\N	0	\N	pending	2023-10-18 10:03:58	2023-10-18 10:03:58	#TX-000103	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
71	1	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	73	1	ltl	ask_for_qoute	\N	0	\N	pending	2023-10-09 10:36:10	2023-10-18 12:33:18	#TX-000071	no	\N	\N	0	\N	\N	\N	0	33.5165256	73.1108949	United Arab Emirates	\N	\N	33.5707966	73.145327	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
104	1	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	85	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-18 16:28:07	2023-10-19 12:56:13	#TX-000104	yes	\N	25	200	275	275	\N	250	25.184237262438835	55.259992964565754	United Arab Emirates	Dubai	\N	25.047127821877247	55.15551958233118	United Arab Emirates	Dubai	\N	+971 552125893	+971 552125893	4	0	0	0
102	1	Trade Centre	Trade Centre	74	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-17 15:17:05	2023-10-18 03:46:26	#TX-000102	yes	\N	15	0	315	315	\N	300	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	4	0	0	0
101	1	Trade Centre	Umm Al Quain	74	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-17 15:02:30	2023-10-18 22:15:20	#TX-000101	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
91	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ltl	approved_by_admin	\N	0	\N	on_process	2023-10-17 09:06:26	2023-10-19 13:30:37	#TX-000091	no	\N	0	0	227	227	\N	227	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	1	0	0	0
105	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	2	\N	approved_by_admin	\N	0	\N	on_process	2023-10-20 13:08:18	2023-10-20 15:45:00	#TX-000105	no	\N	0	0	235	235	\N	235	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	2	0	0	0
100	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-17 13:27:58	2023-10-19 03:29:35	#TX-000100	no	\N	0	0	333	333	\N	333	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	4	0	0	0
97	1	Trade Centre	Umm Al Quain	74	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-17 11:46:24	2023-10-18 08:48:46	#TX-000097	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
95	1	Trade Centre	Umm Al Quain	74	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-17 11:35:01	2023-10-18 08:51:16	#TX-000095	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
67	1	378 St 17, PWD Housing Society Sector D PWD Society, Islamabad, Islamabad Capital Territory, Pakistan	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan	73	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-07 16:24:13	2023-10-18 22:13:38	#TX-000067	no	\N	\N	0	\N	\N	\N	0	33.5707966	73.145327	United Arab Emirates	Dubai	\N	33.5165256	73.1108949	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
94	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-17 10:47:21	2023-10-18 08:54:27	#TX-000094	yes	\N	0	0	300	300	\N	300	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	4	0	0	0
99	1	Trade Centre	Umm Al Quain	74	1	ftl	driver_qouted	\N	0	\N	on_process	2023-10-17 12:04:06	2023-10-20 16:42:26	#TX-000099	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
107	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	2	\N	pending	\N	0	\N	pending	2023-10-20 16:51:40	2023-10-20 16:51:40	#TX-000107	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
124	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	673C+W8M - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-10-26 09:57:27	2023-10-26 09:57:27	\N	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
118	1	Trade Centre	Trade Centre	74	1	ftl	driver_qouted	\N	0	\N	pending	2023-10-24 15:18:46	2023-10-24 16:41:20	#TX-000114-1	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	114	0	0
108	1	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	85	1	ltl	driver_qouted	\N	0	\N	pending	2023-10-20 16:58:26	2023-10-20 17:04:07	#TX-000108	no	\N	\N	0	\N	\N	\N	0	25.047127821877247	55.15551958233118	United Arab Emirates	\N	\N	25.184237262438835	55.259992964565754	United Arab Emirates	Dubai	\N	+971 552125893	+971 552125893	0	0	0	0
109	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	\N	73	4	\N	pending	\N	0	\N	pending	2023-10-20 21:32:36	2023-10-20 21:32:36	#TX-000109	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	\N	\N	\N	\N	\N	+971 090078601	\N	0	0	0	0
110	0		\N	73	4	\N	pending	\N	0	\N	pending	2023-10-21 09:30:27	2023-10-21 09:30:27	#TX-000110	no	\N	\N	0	\N	\N	\N	0					\N	\N	\N	\N	\N	\N		\N	0	0	0	0
114	1	Umm Al Quain	Trade Centre	74	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-24 11:51:13	2023-10-24 12:10:23	#TX-000114	no	\N	0	0	300	300	\N	300	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	4	0	0	0
113	1	790 B Block, Millat Town Faisalabad, Punjab, Pakistan,	790 B Block, Millat Town Faisalabad, Punjab, Pakistan,	105	1	ftl	pending	\N	0	\N	pending	2023-10-24 11:38:30	2023-10-24 11:38:30	#TX-000113	no	\N	\N	0	\N	\N	\N	0	31.488138763909944	73.09930074959993	United Arab Emirates	Abu Dhabi	\N	31.488138763909944	73.09930074959993	United Arab Emirates	Abu Dhabi	\N	+971 3204504501	+971 3204504501	0	0	0	0
115	1	Umm Al Quain	Trade Centre	74	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-24 12:11:37	2023-10-24 12:48:00	#TX-000115	yes	\N	0	0	1000	1000	\N	1000	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	4	0	0	0
112	1	Trade Centre	Trade Centre	74	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-24 11:35:07	2023-10-24 11:48:20	#TX-000112	no	\N	0	0	600	600	\N	600	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	4	0	0	0
117	1	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	85	1	ltl	pending	\N	0	\N	pending	2023-10-24 14:48:38	2023-10-24 14:48:38	#TX-000117	no	\N	\N	0	\N	\N	\N	0	25.047127821877247	55.15551958233118	United Arab Emirates	\N	\N	25.184237262438835	55.259992964565754	United Arab Emirates	Dubai	\N	+971 552125893	+971 552125893	0	0	0	0
111	1	Trade Centre	Umm Al Quain	74	1	ftl	driver_qouted	\N	0	\N	completed	2023-10-24 11:21:33	2023-11-13 15:06:29	#TX-000111	no	\N	0	0	300	300	\N	300	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.26546546	55.5874386546	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	4	0	0	0
121	1	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	85	2		pending	\N	0	\N	completed	2023-10-25 10:36:38	2023-10-25 10:42:15	\N	yes	1231321	\N	0	\N	\N	1	0	25.047127821877247	55.15551958233118	United Arab Emirates	\N	\N	25.184237262438835	55.259992964565754	United Arab Emirates	Dubai	\N	+971 552125893	+971 552125893	0	0	0	0
119	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-10-24 17:00:17	2023-10-24 17:00:17	#TX-000100-1	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	100	0	0
122	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-10-25 16:14:22	2023-10-25 16:14:22	\N	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
120	1	Al manara tower		85	4		driver_qouted	\N	0	\N	pending	2023-10-25 10:31:59	2023-10-25 10:32:42	#TX-000120	no	6735127531	\N	0	\N	\N	1	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	0	0	0	0
125	1	Trade Centre	Trade Centre	74	3	ftl	pending	\N	0	\N	pending	2023-10-26 09:58:46	2023-10-26 09:58:46	\N	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
123	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ltl	pending	\N	0	\N	pending	2023-10-25 17:32:34	2023-10-25 17:32:34	\N	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
126	1	Trade Centre	Trade Centre	74	3	ftl	pending	\N	0	\N	pending	2023-10-26 10:02:54	2023-10-26 10:02:54	#TX-000126	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
127	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	673C+W8M - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-10-26 10:08:31	2023-10-26 10:08:31	#TX-000127	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
128	1	Al manara tower	Al bayat	85	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-26 10:27:59	2023-10-26 10:28:00	#TX-000128	no	654757567	\N	0	\N	\N	1	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	0	0	0	0
129	1	Al manara tower	Al bayat	108	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-26 10:28:43	2023-10-26 10:28:43	#TX-000129	no	6735127531	\N	0	\N	\N	1	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	0	0	0	0
132	1	Al manara tower		85	4		ask_for_qoute	\N	0	\N	pending	2023-10-26 11:25:07	2023-10-26 11:25:07	#TX-000132	no	354365	\N	0	\N	\N	1	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	0	0	0	0
131	1	Al manara tower	Al bayat	85	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-26 10:51:10	2023-10-26 10:51:10	#TX-000131	no	5436654	\N	0	\N	\N	1	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	0	0	0	0
143	1	Trade Centre	Trade Centre	74	1	ftl	pending	\N	0	\N	pending	2023-10-26 15:19:12	2023-10-26 15:19:12	#TX-000114-2	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	114	0	0
140	1	Mall Of Emirates - Al Barsha Rd - Al Barsha - Al Barsha 1 - Dubai - United Arab Emirates	HH22+8X8 - Al Bootain - Al Butain - Umm Al Quawain - United Arab Emirates	85	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-26 12:43:38	2023-10-26 12:44:22	#TX-000140	no	46546754765	2	0	0	0	1	0	25.1158136	55.203267	\N	\N	\N	25.5507975	55.5524476	\N	\N	\N	\N	\N	0	0	0	0
130	1	12 Marasi Dr - Business Bay - Bay Square - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	108	1	ltl	approved_by_admin	\N	0	\N	completed	2023-10-26 10:48:29	2023-10-26 11:26:46	#TX-000130	yes	\N	100	1100	1100	1100	\N	1000	25.185813143901825	55.2819012477994	United Arab Emirates	\N	\N	25.184230284096706	55.25999095290899	United Arab Emirates	Dubai	\N	+971 524158669	+971 524158669	4	0	0	0
133	0		\N	108	4	\N	pending	\N	0	\N	pending	2023-10-26 11:32:48	2023-10-26 11:32:48	#TX-000133	no	\N	\N	0	\N	\N	\N	0					\N	\N	\N	\N	\N	\N		\N	0	0	0	0
134	1	Al manara tower		108	4		approved_by_admin	\N	0	\N	pending	2023-10-26 11:36:57	2023-10-26 11:36:57	#TX-000134	no	6735127531	\N	0	\N	\N	1	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	0	0	0	0
135	1	Al manara tower		108	4		ask_for_qoute	\N	0	\N	pending	2023-10-26 11:41:11	2023-10-26 11:41:11	#TX-000135	no	6735127531	\N	0	\N	\N	1	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	0	0	0	0
136	1	Trade Centre	\N	74	4	\N	pending	\N	0	\N	pending	2023-10-26 11:52:55	2023-10-26 11:52:55	#TX-000136	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	\N	\N	\N	\N	\N		\N	0	0	0	0
137	1	Trade Centre	\N	74	4	\N	pending	\N	0	\N	pending	2023-10-26 11:58:14	2023-10-26 11:58:14	#TX-000112-1	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	\N	\N	\N	\N	\N		\N	0	112	0	0
144	1	Trade Centre	Building Materials Mall	74	1	ltl	pending	\N	0	\N	pending	2023-10-26 15:19:53	2023-10-26 15:19:53	#TX-000144	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	\N	\N	25.16533880130602	55.46189738501064	United Arab Emirates	Dubai	\N			0	0	0	0
139	1	HH22+8X8 - Al Bootain - Al Butain - Umm Al Quawain - United Arab Emirates	Dubai International Airport (DXB) - Dubai - United Arab Emirates	85	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-26 12:36:47	2023-10-26 12:36:47	#TX-000139	no	5436546	\N	0	\N	\N	1	0	25.5507975	55.5524476	\N	\N	\N	25.2566466	55.3641488	\N	\N	\N	\N	\N	0	0	0	0
145	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-10-26 15:27:03	2023-10-26 15:27:03	#TX-000142-1	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	142	0	0
138	1	12 Marasi Dr - Business Bay - Bay Square - Dubai - United Arab Emirates,		108	4		pending	\N	0	\N	cancelled	2023-10-26 12:21:35	2023-10-26 14:51:12	#TX-000138	no		\N	0	\N	\N	1	0	25.185813143901825	55.2819012477994	United Arab Emirates	Dubai	\N	\N	\N	\N	\N	\N	+971 524158669	\N	0	0	0	0
141	1	17 Al Khwaher St - Jumeirah - Jumeirah 3 - Dubai - United Arab Emirates,	Office No: 303, 3rd Floor, Education Zone Bldg - Near Al Qusais Metro Station - اﻟﻘﺼﻴﺺ - القصيص ١ - دبي - United Arab Emirates,	109	1	ftl	pending	\N	0	\N	pending	2023-10-26 15:00:33	2023-10-26 15:00:33	\N	no	\N	\N	0	\N	\N	\N	0	25.190578589794992	55.23016478866339	United Arab Emirates	Dubai	\N	25.276981694222343	55.37242949008942	United Arab Emirates	Dubai	\N	+971 554228898	+971 554228898	0	0	0	0
146	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	ask_for_qoute	\N	0	\N	qoutes_received	2023-10-26 15:28:33	2023-10-26 15:34:34	#TX-000142-2	no	\N	16	0	0	0	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	1	142	0	0
147	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-10-26 15:40:14	2023-10-26 15:40:14	#TX-000147	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
148	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-10-26 15:41:52	2023-10-26 15:41:52	#TX-000148	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
142	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ltl	ask_for_qoute	\N	0	\N	completed	2023-10-26 15:14:50	2023-10-26 17:51:57	#TX-000142	yes	\N	40	440	440	440	\N	400	33.518045571861066	73.10975566506386	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	4	0	0	0
150	1	Trade Centre	Trade Centre	74	3	ftl	pending	\N	0	\N	pending	2023-10-26 16:38:25	2023-10-26 16:38:25	#TX-000150	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	0	0	0
151	1	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	85	2	\N	pending	\N	0	\N	pending	2023-10-26 16:38:40	2023-10-26 16:38:40	#TX-000151	no	\N	\N	0	\N	\N	\N	0	25.047127821877247	55.15551958233118	United Arab Emirates	\N	\N	25.184237262438835	55.259992964565754	United Arab Emirates	Dubai	\N	+971 552125893	+971 552125893	0	0	0	0
152	1	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	85	1	ftl	pending	\N	0	\N	pending	2023-10-26 16:40:46	2023-10-26 16:40:46	#TX-000152	no	\N	\N	0	\N	\N	\N	0	25.047127821877247	55.15551958233118	United Arab Emirates	Dubai	\N	25.184237262438835	55.259992964565754	United Arab Emirates	Dubai	\N	+971 552125893	+971 552125893	0	0	0	0
154	1	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	85	1	ltl	pending	\N	0	\N	pending	2023-10-26 17:14:28	2023-10-26 17:14:28	#TX-000154	no	\N	\N	0	\N	\N	\N	0	25.047127821877247	55.15551958233118	United Arab Emirates	\N	\N	25.184237262438835	55.259992964565754	United Arab Emirates	Dubai	\N	+971 552125893	+971 552125893	0	0	0	0
155	1	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	85	2	\N	pending	\N	0	\N	pending	2023-10-26 17:15:18	2023-10-26 17:15:18	#TX-000155	no	\N	\N	0	\N	\N	\N	0	25.047127821877247	55.15551958233118	United Arab Emirates	\N	\N	25.184237262438835	55.259992964565754	United Arab Emirates	Dubai	\N	+971 552125893	+971 552125893	0	0	0	0
156	1	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	\N	85	4	\N	pending	\N	0	\N	pending	2023-10-26 17:17:17	2023-10-26 17:17:17	#TX-000156	no	\N	\N	0	\N	\N	\N	0	25.047127821877247	55.15551958233118	United Arab Emirates	Dubai	\N	\N	\N	\N	\N	\N	+971 552125893	\N	0	0	0	0
149	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	approved_by_admin	\N	0	\N	on_process	2023-10-26 15:46:35	2023-10-26 15:56:24	#TX-000149	no	\N	70	0	1070	1070	\N	1000	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	1	0	0	0
157	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	673C+W8M - Dubai - United Arab Emirates,	73	3	ltl	pending	\N	0	\N	pending	2023-10-26 18:22:21	2023-10-26 18:22:21	#TX-000157	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	\N	\N	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
158	1	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	Sharjah International Airport - Sharjah International Airport - Sharjah - United Arab Emirates,	110	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-27 09:13:45	2023-10-27 09:46:48	#TX-000158	yes	\N	130	780	780	780	\N	650	25.184229070471947	55.2599922940135	United Arab Emirates	Dubai	\N	25.321364732892214	55.520540066063404	United Arab Emirates	Dubai	\N	+971 5341889666	+971 5341889666	4	0	0	0
153	1	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	85	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-26 17:12:44	2023-10-26 18:11:39	#TX-000153	no	\N	37.5	0	537.5	537.5	\N	500	25.047127821877247	55.15551958233118	United Arab Emirates	Dubai	\N	25.184237262438835	55.259992964565754	United Arab Emirates	Dubai	\N	+971 552125893	+971 552125893	4	0	0	0
160	1	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	Sharjah International Airport - Sharjah International Airport - Sharjah - United Arab Emirates,	110	3	ftl	pending	\N	0	\N	pending	2023-10-27 09:52:03	2023-10-27 09:52:03	#TX-000160	no	\N	\N	0	\N	\N	\N	0	25.184229070471947	55.2599922940135	United Arab Emirates	Dubai	\N	25.321364732892214	55.520540066063404	United Arab Emirates	Dubai	\N	+971 5341889666	+971 5341889666	0	0	0	0
161	1	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	Sharjah International Airport - Sharjah International Airport - Sharjah - United Arab Emirates,	110	1	ltl	approved_by_admin	\N	0	\N	completed	2023-10-27 10:02:51	2023-10-27 10:08:57	#TX-000161	no	\N	37.5	0	287.5	287.5	\N	250	25.184229070471947	55.2599922940135	United Arab Emirates	\N	\N	25.321364732892214	55.520540066063404	United Arab Emirates	Dubai	\N	+971 5341889666	+971 5341889666	4	0	0	0
159	1	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	Sharjah International Airport - Sharjah International Airport - Sharjah - United Arab Emirates,	110	3	ftl	pending	\N	0	\N	completed	2023-10-27 09:51:14	2023-10-27 10:00:54	#TX-000159	no		\N	0	\N	\N	1	0	25.184229070471947	55.2599922940135	United Arab Emirates	Dubai	\N	25.321364732892214	55.520540066063404	United Arab Emirates	Dubai	\N	+971 5341889666	+971 5341889666	0	0	0	0
163	1	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	Sharjah International Airport - Sharjah International Airport - Sharjah - United Arab Emirates,	110	2		pending	\N	0	\N	completed	2023-10-27 10:12:19	2023-10-27 10:22:48	#TX-000163	no		\N	0	\N	\N	1	0	25.184229070471947	55.2599922940135	United Arab Emirates	\N	\N	25.321364732892214	55.520540066063404	United Arab Emirates	Dubai	\N	+971 5341889666	+971 5341889666	0	0	0	0
162	1	Trade Centre	Trade Centre	74	3	ftl	approved_by_admin	\N	0	\N	completed	2023-10-27 10:11:52	2023-10-27 10:43:33	#TX-000115-1	no		\N	0	\N	\N	1	0	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	115	0	0
164	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	3	ftl	pending	\N	0	\N	completed	2023-10-27 10:22:59	2023-10-27 10:28:42	#TX-000164	no		\N	0	\N	\N	1	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
166	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	3	ftl	pending	\N	0	\N	pending	2023-10-27 10:29:15	2023-10-27 10:29:15	#TX-000164-1	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	164	0	0
167	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	driver_qouted	\N	0	\N	pending	2023-10-27 10:46:08	2023-11-07 10:56:53	#TX-000167	no	\N	10	0	0	0	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
165	1	Trade Centre	Trade Centre	74	2	\N	approved_by_admin	\N	0	\N	completed	2023-10-27 10:27:02	2023-10-27 10:44:27	#TX-000115-2	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	\N	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N	+971 8277272939393939	+971 8277272939393939	0	115	0	0
174	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	673C+W8M - Dubai - United Arab Emirates,	73	3	ltl	pending	\N	0	\N	pending	2023-11-09 11:14:14	2023-11-09 11:14:14	#TX-000174	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	\N	\N	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
168	1	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	73	1	ftl	pending	\N	0	\N	pending	2023-10-27 10:51:56	2023-10-27 10:51:56	#TX-000168	no	\N	\N	0	\N	\N	\N	0	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
171	1	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	Jumeirah Golf Estates	113	2		approved_by_admin	\N	0	\N	completed	2023-10-27 11:52:31	2023-10-27 11:55:40	#TX-000171	no		\N	0	\N	\N	1	0	25.184231497721463	55.25999363511801	United Arab Emirates	\N	\N	25.01920789158473	55.2010665088892	United Arab Emirates	Dubai	\N	+971 544568266	+971 544568266	0	0	0	0
175	1	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	673C+W8M - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-11-09 12:41:13	2023-11-09 12:41:13	#TX-000175	no	\N	\N	0	\N	\N	\N	0	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
169	1	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	73	1	ftl	ask_for_qoute	\N	0	\N	pending	2023-10-27 10:52:15	2023-11-01 13:45:20	#TX-000169	no	\N	10	0	0	0	\N	0	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
172	1	38, Ananda Pally, Jadavpur, Kolkata, West Bengal 700092, India,	New Delhi	84	1	ftl	approved_by_admin	\N	0	\N	completed	2023-11-07 11:10:19	2023-11-07 11:21:00	#TX-000172	yes	\N	100	1100	1100	1100	\N	1000	22.489859563358984	88.37032735347748	United Arab Emirates	Abu Dhabi	\N	28.613939179213727	77.20902130007744	United Arab Emirates	Dubai	\N	+971 5515256547	+971 5515256547	4	0	0	0
170	1	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	Jumeirah Golf Estates	113	1	ftl	approved_by_admin	\N	0	\N	completed	2023-10-27 11:16:13	2023-10-27 11:50:19	#TX-000170	no	\N	72.5	0	722.5	722.5	\N	650	25.184231497721463	55.25999363511801	United Arab Emirates	Dubai	\N	25.01920789158473	55.2010665088892	United Arab Emirates	Dubai	\N	+971 544568266	+971 544568266	4	0	0	0
176	1	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	73	1	ftl	pending	\N	0	\N	pending	2023-11-09 12:42:48	2023-11-09 12:42:48	#TX-000176	no	\N	\N	0	\N	\N	\N	0	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
173	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-11-09 11:09:37	2023-11-09 11:09:37	#TX-000173	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
177	0	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	85	1		ask_for_qoute	\N	0	\N	pending	2023-11-09 17:44:45	2023-11-09 17:44:45	#TX-000177	no	12121212	\N	0	\N	\N	1	0	25.047127821877247		\N	\N	\N	25.184237262438835	55.259992964565754	\N	\N	\N	\N	\N	0	0	0	0
179	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	2	\N	pending	\N	0	\N	pending	2023-11-10 10:47:33	2023-11-10 10:47:33	#TX-000179	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
180	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-11-10 16:27:26	2023-11-10 16:27:26	#TX-000180	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
178	0	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,		85	3		driver_qouted	\N	0	\N	pending	2023-11-10 07:57:10	2023-11-13 15:04:20	#TX-000178	no	12121212	\N	0	\N	\N	1	0	25.047127821877247		\N	\N	\N			\N	\N	\N	\N	\N	0	0	0	0
185	1	673C+W8M - Dubai - United Arab Emirates,	57PR+HR - Business Bay - Dubai - United Arab Emirates,	140	1	ftl	pending	\N	0	\N	pending	2023-11-13 10:08:50	2023-11-13 10:08:50	#TX-000185	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.186422980892413	55.29201988130808	United Arab Emirates	Dubai	\N	+971 1236547890	+971 1236547890	0	0	0	0
186	1	Building Materials Mall	Trade Centre	122	1	ftl	pending	\N	0	\N	pending	2023-11-13 10:14:07	2023-11-13 10:14:07	#TX-000186	no	\N	\N	0	\N	\N	\N	0	25.16533880130602	55.46189738501064	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N			0	0	0	0
182	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-11-10 16:48:56	2023-11-10 16:48:56	#TX-000182	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
187	1	Trade Centre	Building Materials Mall	122	1	ltl	pending	\N	0	\N	pending	2023-11-13 10:14:48	2023-11-13 10:14:48	#TX-000187	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	\N	\N	25.16533880130602	55.46189738501064	United Arab Emirates	Dubai	\N			0	0	0	0
116	1	25W4+V62 - Jumeirah Park - Dubai - United Arab Emirates,	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	85	1	ftl	driver_qouted	\N	0	\N	qoutes_received	2023-10-24 14:47:56	2023-11-11 14:18:29	#TX-000116	no	\N	3	0	0	0	\N	0	25.047127821877247	55.15551958233118	United Arab Emirates	Dubai	\N	25.184237262438835	55.259992964565754	United Arab Emirates	Dubai	\N	+971 552125893	+971 552125893	1	0	0	0
183	1	673C+W8M - Dubai - United Arab Emirates,	567R+8R4 - Al Quoz - Al Quoz 3 - Dubai - United Arab Emirates,	133	1	ftl	pending	\N	0	\N	pending	2023-11-13 09:54:35	2023-11-13 09:54:35	#TX-000183	no	\N	\N	0	\N	\N	\N	0	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	25.1633635578166	55.24210296571255	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	0	0	0	0
184	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-11-13 10:04:42	2023-11-13 10:04:42	#TX-000184	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
188	1	673C+W8M - Dubai - United Arab Emirates,	57PR+HR - Business Bay - Dubai - United Arab Emirates,	140	1	ftl	pending	\N	0	\N	pending	2023-11-13 10:16:41	2023-11-13 10:16:41	#TX-000188	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.186422980892413	55.29201988130808	United Arab Emirates	Dubai	\N	+971 1236547890	+971 1236547890	0	0	0	0
189	1	673C+W8M - Dubai - United Arab Emirates,	57PR+HR - Business Bay - Dubai - United Arab Emirates,	140	1	ftl	pending	\N	0	\N	pending	2023-11-13 10:20:52	2023-11-13 10:20:52	#TX-000189	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.186422980892413	55.29201988130808	United Arab Emirates	Dubai	\N	+971 1236547890	+971 1236547890	0	0	0	0
190	1	567R+8R4 - Al Quoz - Al Quoz 3 - Dubai - United Arab Emirates,	673C+W8M - Dubai - United Arab Emirates,	133	1	ftl	pending	\N	0	\N	pending	2023-11-13 10:24:45	2023-11-13 10:24:45	#TX-000190	no	\N	\N	0	\N	\N	\N	0	25.1633635578166	55.24210296571255	United Arab Emirates	Dubai	\N	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	0	0	0	0
191	1	Trade Centre	Building Materials Mall	140	1	ltl	pending	\N	0	\N	pending	2023-11-13 10:27:35	2023-11-13 10:27:35	#TX-000191	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	\N	\N	25.16533880130602	55.46189738501064	United Arab Emirates	Dubai	\N			0	0	0	0
192	1	Building Materials Mall	Trade Centre	122	1	ftl	pending	\N	0	\N	pending	2023-11-13 10:43:59	2023-11-13 10:43:59	#TX-000192	no	\N	\N	0	\N	\N	\N	0	25.16533880130602	55.46189738501064	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N			0	0	0	0
193	1	Building Materials Mall	Trade Centre	122	1	ftl	pending	\N	0	\N	pending	2023-11-13 10:44:10	2023-11-13 10:44:10	#TX-000193	no	\N	\N	0	\N	\N	\N	0	25.16533880130602	55.46189738501064	United Arab Emirates	Dubai	\N	25.224144623109982	55.284972986352955	United Arab Emirates	Dubai	\N			0	0	0	0
194	1	673C+W8M - Dubai - United Arab Emirates,	567R+8R4 - Al Quoz - Al Quoz 3 - Dubai - United Arab Emirates,	133	1	ftl	pending	\N	0	\N	pending	2023-11-13 11:06:49	2023-11-13 11:06:49	#TX-000194	no	\N	\N	0	\N	\N	\N	0	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	25.1633635578166	55.24210296571255	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	0	0	0	0
195	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-11-13 11:38:16	2023-11-13 11:38:16	#TX-000195	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
196	1	673C+W8M - Dubai - United Arab Emirates,	567R+8R4 - Al Quoz - Al Quoz 3 - Dubai - United Arab Emirates,	133	1	ftl	pending	\N	0	\N	pending	2023-11-13 11:49:22	2023-11-13 11:49:22	#TX-000196	no	\N	\N	0	\N	\N	\N	0	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	25.1633635578166	55.24210296571255	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	0	0	0	0
197	1	673C+W8M - Dubai - United Arab Emirates,	6727+556 - 13th St - Al Wasl - Dubai - United Arab Emirates,	133	3	ftl	pending	\N	0	\N	pending	2023-11-13 13:35:37	2023-11-13 13:35:37	#TX-000197	no	\N	\N	0	\N	\N	\N	0	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	25.168942204444328	55.24138446897268	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	0	0	0	0
198	1	F93G+HW5 - Al Manhal - Abu Dhabi - United Arab Emirates,	\N	133	4	\N	pending	\N	0	\N	pending	2023-11-13 13:37:28	2023-11-13 13:37:28	#TX-000198	no	\N	\N	0	\N	\N	\N	0	24.453887367074184	54.37734369188547	United Arab Emirates	Abu Dhabi	\N	\N	\N	\N	\N	\N	+91 8920524739	\N	0	0	0	0
181	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	approved_by_admin	\N	0	\N	completed	2023-11-10 16:30:03	2023-11-13 16:26:45	#TX-000181	no	\N	0	0	222	222	\N	222	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	4	0	0	0
199	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	pending	\N	0	\N	pending	2023-11-13 13:46:59	2023-11-13 13:46:59	#TX-000199	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
200	1	F93G+HW5 - Al Manhal - Abu Dhabi - United Arab Emirates,	673C+W8M - Dubai - United Arab Emirates,	133	1	ltl	pending	\N	0	\N	pending	2023-11-13 13:49:40	2023-11-13 13:49:40	#TX-000200	no	\N	\N	0	\N	\N	\N	0	24.453887367074184	54.37734369188547	United Arab Emirates	\N	\N	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	0	0	0	0
201	1	F93G+HW5 - Al Manhal - Abu Dhabi - United Arab Emirates,	673C+W8M - Dubai - United Arab Emirates,	133	3	ftl	pending	\N	0	\N	pending	2023-11-13 13:56:05	2023-11-13 13:56:05	#TX-000201	no	\N	\N	0	\N	\N	\N	0	24.453887367074184	54.37734369188547	United Arab Emirates	Abu Dhabi	\N	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	0	0	0	0
202	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	2	\N	pending	\N	0	\N	pending	2023-11-13 13:56:48	2023-11-13 13:56:48	#TX-000202	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
203	1	F93G+HW5 - Al Manhal - Abu Dhabi - United Arab Emirates,	673C+W8M - Dubai - United Arab Emirates,	133	1	ftl	pending	\N	0	\N	pending	2023-11-13 13:56:54	2023-11-13 13:56:54	#TX-000203	no	\N	\N	0	\N	\N	\N	0	24.453887367074184	54.37734369188547	United Arab Emirates	Abu Dhabi	\N	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	0	0	0	0
205	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ltl	pending	\N	0	\N	pending	2023-11-13 14:05:33	2023-11-13 14:05:33	#TX-000205	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
206	1	Trade Centre	Building Materials Mall	122	1	ltl	pending	\N	0	\N	pending	2023-11-13 14:09:01	2023-11-13 14:09:01	#TX-000206	no	\N	\N	0	\N	\N	\N	0	25.224144623109982	55.284972986352955	United Arab Emirates	\N	\N	25.16533880130602	55.46189738501064	United Arab Emirates	Dubai	\N			0	0	0	0
207	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ltl	pending	\N	0	\N	pending	2023-11-13 14:10:43	2023-11-13 14:10:43	#TX-000207	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
208	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ltl	pending	\N	0	\N	pending	2023-11-13 14:11:50	2023-11-13 14:11:50	#TX-000208	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
209	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ltl	pending	\N	0	\N	pending	2023-11-13 14:15:46	2023-11-13 14:15:46	#TX-000209	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
210	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ltl	pending	\N	0	\N	pending	2023-11-13 14:19:06	2023-11-13 14:19:06	#TX-000210	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
211	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ltl	pending	\N	0	\N	pending	2023-11-13 14:19:27	2023-11-13 14:19:27	#TX-000211	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
212	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	2	\N	pending	\N	0	\N	pending	2023-11-13 14:23:05	2023-11-13 14:23:05	#TX-000212	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
213	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	2	\N	pending	\N	0	\N	pending	2023-11-13 14:23:27	2023-11-13 14:23:27	#TX-000213	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
214	1	673C+W8M - Dubai - United Arab Emirates,	\N	73	4	\N	pending	\N	0	\N	pending	2023-11-13 14:25:23	2023-11-13 14:25:23	#TX-000214	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	\N	\N	\N	\N	\N	+971 090078601	\N	0	0	0	0
215	1	673C+W8M - Dubai - United Arab Emirates,	\N	73	4	\N	pending	\N	0	\N	pending	2023-11-13 14:28:20	2023-11-13 14:28:20	#TX-000215	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	\N	\N	\N	\N	\N	+971 090078601	\N	0	0	0	0
216	1	673C+W8M - Dubai - United Arab Emirates,	\N	73	4	\N	pending	\N	0	\N	pending	2023-11-13 14:28:43	2023-11-13 14:28:43	#TX-000216	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	\N	\N	\N	\N	\N	+971 090078601	\N	0	0	0	0
217	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	3	ftl	pending	\N	0	\N	pending	2023-11-13 14:29:25	2023-11-13 14:29:25	#TX-000217	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
204	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	approved_by_admin	\N	0	\N	on_process	2023-11-13 14:04:06	2023-11-14 11:18:08	#TX-000204	no	\N	0	0	5	5	\N	5	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	2	0	0	0
218	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	3	ltl	pending	\N	0	\N	pending	2023-11-13 14:30:09	2023-11-13 14:30:09	#TX-000218	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
221	1	F93G+HW5 - Al Manhal - Abu Dhabi - United Arab Emirates,	673C+W8M - Dubai - United Arab Emirates,	133	1	ftl	pending	\N	0	\N	pending	2023-11-13 15:18:15	2023-11-13 15:19:42	#TX-000221	no		\N	0	\N	\N	1	0	24.453887367074184	54.37734369188547	United Arab Emirates	Abu Dhabi	\N	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	0	0	0	0
227	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ltl	pending	\N	0	\N	pending	2023-11-13 22:42:57	2023-11-13 22:42:57	#TX-000227	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
220	1	F93G+HW5 - Al Manhal - Abu Dhabi - United Arab Emirates,	673C+W8M - Dubai - United Arab Emirates,	133	1	ftl	pending	\N	0	\N	pending	2023-11-13 14:58:09	2023-11-13 14:58:09	#TX-000220	no	\N	\N	0	\N	\N	\N	0	24.453887367074184	54.37734369188547	United Arab Emirates	Abu Dhabi	\N	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	0	0	0	0
225	1	673C+W8M - Dubai - United Arab Emirates,	46VG+6J8 - Al Quoz - Dubai - United Arab Emirates,	142	1	ftl	driver_qouted	\N	0	\N	on_process	2023-11-13 18:32:21	2023-11-13 18:38:32	#TX-000225	no	\N	0	0	2	2	\N	2	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	25.143800471524028	55.226107612252235	United Arab Emirates	Abu Dhabi	\N	+971 000000000	+971 000000000	2	0	0	0
222	1	F93G+HW5 - Al Manhal - Abu Dhabi - United Arab Emirates,	673C+W8M - Dubai - United Arab Emirates,	133	1	ftl	ask_for_qoute	\N	0	\N	on_process	2023-11-13 15:24:06	2023-11-13 15:50:12	#TX-000222	yes	23ererw	560	0	5960	5960	1	5400	24.453887367074184	54.37734369188547	United Arab Emirates	Abu Dhabi	\N	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	1	0	0	0
224	1	673C+W8M - Dubai - United Arab Emirates,	F93G+HW5 - Al Manhal - Abu Dhabi - United Arab Emirates,	133	1	ftl	pending	\N	0	\N	pending	2023-11-13 16:51:52	2023-11-13 16:51:52	#TX-000224	no	\N	\N	0	\N	\N	\N	0	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	24.453887367074184	54.37734369188547	United Arab Emirates	Abu Dhabi	\N	+91 8920524739	+91 8920524739	0	0	0	0
219	1	F93G+HW5 - Al Manhal - Abu Dhabi - United Arab Emirates,	673C+W8M - Dubai - United Arab Emirates,	133	1	ftl	approved_by_admin	\N	0	\N	on_process	2023-11-13 14:56:24	2023-11-13 15:05:51	#TX-000219	no		400	0	10400	10400	1	10000	24.453887367074184	54.37734369188547	United Arab Emirates	Abu Dhabi	\N	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	1	0	0	0
228	1	673C+W8M - Dubai - United Arab Emirates,	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	73	2	\N	pending	\N	0	\N	pending	2023-11-13 22:54:42	2023-11-13 22:54:42	#TX-000228	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	\N	\N	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
229	1	673C+W8M - Dubai - United Arab Emirates,	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	73	3	ftl	pending	\N	0	\N	pending	2023-11-13 23:10:22	2023-11-13 23:10:22	#TX-000229	no	\N	\N	0	\N	\N	\N	0	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	33.518045571861066	73.10975566506386	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
223	1	F93G+HW5 - Al Manhal - Abu Dhabi - United Arab Emirates,	673C+W8M - Dubai - United Arab Emirates,	133	1	ftl	driver_qouted	\N	0	\N	qoutes_received	2023-11-13 15:47:56	2023-11-14 11:15:23	#TX-000223	no	\N	0	0	3	3	\N	3	24.453887367074184	54.37734369188547	United Arab Emirates	Abu Dhabi	\N	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	+91 8920524739	+91 8920524739	1	0	0	0
230	1	Rosemary Ave, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	3	ltl	pending	\N	0	\N	pending	2023-11-13 23:24:07	2023-11-13 23:24:07	#TX-000230	no	\N	\N	0	\N	\N	\N	0	33.518045571861066	73.10975566506386	United Arab Emirates	\N	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	0	0	0	0
231	1	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	\N	73	4	\N	pending	\N	0	\N	pending	2023-11-13 23:35:58	2023-11-13 23:35:58	#TX-000231	no	\N	\N	0	\N	\N	\N	0	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	\N	\N	\N	\N	\N	+971 090078601	\N	0	0	0	0
233	1	46VG+6J8 - Al Quoz - Dubai - United Arab Emirates,		142	4		approved_by_admin	\N	0	\N	qoutes_received	2023-11-14 10:25:33	2023-11-14 12:39:37	#TX-000233	yes	44	\N	0	\N	\N	1	0	25.143800471524028	55.226107612252235	United Arab Emirates	Abu Dhabi	\N	\N	\N	\N	\N	\N	+971 000000000	\N	1	0	0	0
232	1	673C+W8M - Dubai - United Arab Emirates,	\N	142	4	\N	driver_qouted	\N	0	\N	completed	2023-11-14 09:54:39	2023-11-14 10:10:39	#TX-000232	yes	\N	66	1000	8300	8300	\N	5000	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	\N	\N	\N	\N	\N	+971 000000000	\N	4	0	0	0
226	1	673C+W8M - Dubai - United Arab Emirates,	Unnamed Road - Downtown Dubai - Dubai - United Arab Emirates,	73	1	ftl	approved_by_admin	\N	0	\N	completed	2023-11-13 22:23:37	2023-11-14 11:27:53	#TX-000226	no	\N	0	0	1234	1234	\N	1234	25.204851967284775	55.27078282088041	United Arab Emirates	Dubai	\N	25.194987682373487	55.27841404080391	United Arab Emirates	Dubai	\N	+971 090078601	+971 090078601	4	0	0	0
234	1	C/1B, Bapuji Nagar, Jadavpur, Kolkata, West Bengal 700032, India,	G929+88J, Poddar Nagar, Jadavpur, Kolkata, West Bengal 700032, India,	145	1	ftl	approved_by_admin	\N	0	\N	qoutes_received	2023-11-14 12:57:29	2023-11-14 13:01:43	#TX-000234	no	\N	\N	0	\N	\N	\N	0	22.4893236473253	88.37173450738192	United Arab Emirates	Dubai	\N	22.500724271233974	88.36815275251865	United Arab Emirates	Dubai	\N	+971 987466666	+971 987466666	1	0	0	0
235	1	C/1B, Bapuji Nagar, Jadavpur, Kolkata, West Bengal 700032, India,	G929+88J, Poddar Nagar, Jadavpur, Kolkata, West Bengal 700032, India,	145	1	ftl	pending	\N	0	\N	pending	2023-11-14 13:04:56	2023-11-14 13:04:56	#TX-000235	no	\N	\N	0	\N	\N	\N	0	22.4893236473253	88.37173450738192	United Arab Emirates	Dubai	\N	22.500724271233974	88.36815275251865	United Arab Emirates	Dubai	\N	+971 987466666	+971 987466666	0	0	0	0
236	1	673C+W8M - Dubai - United Arab Emirates,	39 Street 35 - Al Barsha - Al Barsha South - Dubai - United Arab Emirates,	146	1	ftl	pending	\N	0	\N	pending	2023-11-14 13:09:56	2023-11-14 13:09:56	#TX-000236	no	\N	\N	0	\N	\N	\N	0	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	25.091268543506686	55.24340819567442	United Arab Emirates	Dubai	\N	+971 8424554646	+971 8424554646	0	0	0	0
237	1	673C+W8M - Dubai - United Arab Emirates,	39 Street 35 - Al Barsha - Al Barsha South - Dubai - United Arab Emirates,	146	1	ftl	pending	\N	0	\N	pending	2023-11-14 13:10:22	2023-11-14 13:10:22	#TX-000237	no	\N	\N	0	\N	\N	\N	0	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	25.091268543506686	55.24340819567442	United Arab Emirates	Dubai	\N	+971 8424554646	+971 8424554646	0	0	0	0
238	1	673C+W8M - Dubai - United Arab Emirates,	39 Street 35 - Al Barsha - Al Barsha South - Dubai - United Arab Emirates,	146	1	ftl	pending	\N	0	\N	pending	2023-11-14 13:10:55	2023-11-14 13:10:55	#TX-000238	no	\N	\N	0	\N	\N	\N	0	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	25.091268543506686	55.24340819567442	United Arab Emirates	Dubai	\N	+971 8424554646	+971 8424554646	0	0	0	0
239	1	673C+W8M - Dubai - United Arab Emirates,	39 Street 35 - Al Barsha - Al Barsha South - Dubai - United Arab Emirates,	146	1	ftl	pending	\N	0	\N	pending	2023-11-14 13:11:14	2023-11-14 13:11:14	#TX-000239	no	\N	\N	0	\N	\N	\N	0	25.20485257399441	55.27078282088041	United Arab Emirates	Dubai	\N	25.091268543506686	55.24340819567442	United Arab Emirates	Dubai	\N	+971 8424554646	+971 8424554646	0	0	0	0
240	1	673C+W8M - Dubai - United Arab Emirates,	39 Street 35 - Al Barsha - Al Barsha South - Dubai - United Arab Emirates,	146	1	ltl	pending	\N	0	\N	pending	2023-11-14 13:11:42	2023-11-14 13:11:42	#TX-000240	no	\N	\N	0	\N	\N	\N	0	25.20485257399441	55.27078282088041	United Arab Emirates	\N	\N	25.091268543506686	55.24340819567442	United Arab Emirates	Dubai	\N	+971 8424554646	+971 8424554646	0	0	0	0
\.


--
-- Data for Name: cart_deligate_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cart_deligate_details (id, item, booking_cart_id, no_of_packages, dimension_of_each_package, weight_of_each_package, total_gross_weight, total_volume_in_cbm, created_at, updated_at) FROM stdin;
9	item testing	51	4	3x2x1	3	12	7x6x5	2023-10-20 11:57:07	2023-10-20 13:05:26
14	356	73	2	120x60	25	50	46x5x5	2023-10-25 16:48:01	2023-10-25 16:48:01
28	12	142	12	23	200	69	12	2023-11-09 11:51:57	2023-11-09 11:51:57
32	Cloths	168	20	2x3x2	10	20	4x8x4	2023-11-13 10:29:56	2023-11-13 10:29:56
33	Cloths	169	20	2x3x2	10	20	4x8x4	2023-11-13 10:30:53	2023-11-13 10:30:53
34	Cloths	170	20	2x3x2	10	20	4x8x4	2023-11-13 10:31:11	2023-11-13 10:31:11
35	Cloths	171	20	2x3x2	10	20	4x8x4	2023-11-13 10:31:39	2023-11-13 10:31:39
36	Cloths	173	20	2x3x2	10	20	4x8x4	2023-11-13 10:31:55	2023-11-13 10:31:55
37	Cloths	177	20	2x3x2	10	20	4x8x4	2023-11-13 10:43:26	2023-11-13 10:43:26
53	yay	304	846	2x2x3	545	9464	0.9	2023-11-14 10:25:40	2023-11-14 10:25:40
54	test	305	10	2x2x3	12	12	0.08	2023-11-14 10:39:00	2023-11-14 10:39:00
55	te	307	12	2x3x4	13	15	0.9	2023-11-14 11:01:40	2023-11-14 11:01:40
\.


--
-- Data for Name: cart_warehousing_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cart_warehousing_details (id, booking_cart_id, items_are_stockable, type_of_storage, item, no_of_pallets, pallet_dimension, weight_per_pallet, total_weight, total_item_cost, created_at, updated_at) FROM stdin;
1	53	yes	2	Test Clothes	20	2x3x2	20	20	4000	2023-10-20 15:51:14	2023-10-20 15:51:14
4	69	yes	2	the	5	100x50	28	28	258096	2023-10-25 13:36:09	2023-10-25 13:36:09
12	250	yes	2	test ware one	2	2x2x2	3	6	600	2023-11-13 14:26:02	2023-11-13 14:26:02
16	301	yes	1	trrs	5	55	55	55	55	2023-11-14 09:52:03	2023-11-14 09:52:03
19	306	yes	2	gg	3	2x2x2	12	13	1234	2023-11-14 10:51:20	2023-11-14 10:51:20
\.


--
-- Data for Name: cities; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cities (id, city_name, city_status, country_id, created_at, updated_at) FROM stdin;
1	Dubai	1	1	2023-07-26 16:49:38	2023-07-26 16:49:38
2	Abu Dhabi	1	1	2023-10-10 08:52:40	2023-10-10 08:52:40
\.


--
-- Data for Name: companies; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.companies (id, name, logo, status, created_at, updated_at, user_id, license_expiry, company_license) FROM stdin;
1	Garner Gilbert Traders	64d1d7d3287b7_1691473875.PNG	active	2023-08-08 09:51:15	2023-08-08 09:51:15	38	2034-06-14	64d1d7d32df4f_1691473875.png
2	D X	6538ac1120e9b_1698212881.jpeg	active	2023-10-25 09:48:01	2023-10-25 09:48:01	106	2023-12-25	6538ac11225d8_1698212881.jpeg
\.


--
-- Data for Name: containers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.containers (id, name, type, dimensions, max_weight_in_metric_tons, icon, status, created_at, updated_at) FROM stdin;
2	20HC	fcl	2*1.1*1.1*1.0	21	65374f4741e95_1698123591.jpg	active	2023-10-24 08:59:51	2023-10-24 08:59:51
1	20 Ft	fcl	2X1X2	16	65374f57b3c7d_1698123607.jpg	active	2023-07-25 23:35:28	2023-10-24 09:00:07
3	40 Ft	fcl	4*1.85*1.80	26	65374f8ece155_1698123662.jpg	active	2023-10-24 09:01:02	2023-10-24 09:01:02
4	40HC	fcl	4*1.85*1.8	30	65374fe368f0e_1698123747.jpg	active	2023-10-24 09:02:27	2023-10-24 09:02:27
\.


--
-- Data for Name: countries; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.countries (country_id, country_name, dial_code, iso_code, lang_code, country_status, created_at, updated_at, deleted_at) FROM stdin;
1	United Arab Emirates	971	UAE	en	1	2023-07-26 16:48:47	2023-07-26 16:48:47	\N
\.


--
-- Data for Name: country_languages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.country_languages (country_lang_id, lang_code, country_id_fk, country_localized_name) FROM stdin;
\.


--
-- Data for Name: deligate_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.deligate_attributes (id, deligate_id, details, created_at, updated_at, name) FROM stdin;
\.


--
-- Data for Name: deligates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.deligates (id, name, icon, status, created_at, updated_at, slug) FROM stdin;
4	Warehousing	64d1d91191699_1691474193.PNG	active	2023-07-26 10:14:14	2023-08-08 09:56:33	warehousing
2	Air Freight	64d1d93758252_1691474231.PNG	active	2023-07-26 10:12:14	2023-08-08 09:57:11	air-freight
1	Trucking	64d1d948eac9f_1691474248.PNG	active	2023-07-26 10:11:17	2023-08-08 09:57:28	trucking
3	Sea Frieght	64d1d95df3c62_1691474269.PNG	active	2023-07-26 10:12:53	2023-08-08 09:57:50	sea-frieght
\.


--
-- Data for Name: driver_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.driver_details (id, user_id, driving_license, mulkia, mulkia_number, is_company, company_id, truck_type_id, total_rides, created_at, updated_at, address, latitude, longitude, emirates_id_or_passport, driving_license_number, driving_license_expiry, driving_license_issued_by, vehicle_plate_number, vehicle_plate_place, emirates_id_or_passport_back) FROM stdin;
3	37	64cd60640e5b9_1691181156.PNG	64cd60641195b_1691181156.PNG	74747474	no	\N	2	0	2023-08-05 00:32:36	2023-08-05 00:32:36	Street 02 Northern Creek	\N	\N	64cd6064122be_1691181156.PNG	8339393	2023-09-10	Dubai	7373733	Dubai	64cd6064192e8_1691181156.PNG
4	47	64de339d4aac7_1692283805.jfif	64de339d4c44a_1692283805.jfif	74747474	no	\N	2	0	2023-08-17 18:50:05	2023-08-17 18:50:05	Business Bay	25.15285477	55.27328796	64de339d4c863_1692283805.jfif	8398738262629	2023-09-10	Dubai	7373733	Dubai	64de339d4ceb5_1692283805.jfif
5	48	64de618c1f1fc_1692295564.jfif	64de618c203a2_1692295564.jfif	74747474	no	\N	2	0	2023-08-17 22:06:04	2023-08-17 22:06:04	Business Bay	25.15285477	55.27328796	64de618c205fa_1692295564.jfif	8398738262	2023-09-10	Dubai	7373733	Dubai	64de618c20b79_1692295564.jfif
6	49	64de75f011738_1692300784.jfif	64de75f01289c_1692300784.jfif	74747474	no	\N	2	0	2023-08-17 23:33:04	2023-08-17 23:33:04	\N	\N	\N	64de75f013027_1692300784.jfif	839873826	2023-09-10	Dubai	7373733	Dubai	64de75f01347e_1692300784.jfif
7	50	64de793225d7c_1692301618.jfif	64de793226ee6_1692301618.jfif	74747474	no	\N	2	0	2023-08-17 23:46:58	2023-08-17 23:46:58	\N	\N	\N	64de793227124_1692301618.jfif	83987382	2023-08-18	Dubai	7373733	Dubai	64de793227399_1692301618.jfif
8	51	64de8ade520c5_1692306142.jpg	64de8ade53130_1692306142.jpg	3256980	no	\N	2	0	2023-08-18 01:02:22	2023-08-18 01:02:22	Business Bay	31.55581769	74.27936409	64de8ade532a6_1692306142.jpg	67854789	2023-08-31	Dubai	852369853	Dubai	64de8ade53441_1692306142.jpg
9	52	64de94a29d213_1692308642.jpg	64de94a29e314_1692308642.jpg	2580	no	\N	2	0	2023-08-18 01:44:02	2023-08-18 01:44:02	Business Bay	31.55581340	74.27936476	64de94a29e49e_1692308642.jpg	222222	2023-08-30	Dubai	55588	Dubai	64de94a29e626_1692308642.jpg
10	58	64df2b86128d5_1692347270.jpg	64df2b8613ada_1692347270.jpg	3366008	no	\N	2	0	2023-08-18 12:27:50	2023-08-18 12:27:50	Business Bay	31.55581883	74.27937079	64df2b8613c93_1692347270.jpg	666777450	2023-08-31	Dubai	22580456	Dubai	64df2b8613e4b_1692347270.jpg
11	59	64df339e472c4_1692349342.jpg	64df339e48288_1692349342.jpg	0000000000000000000000000	no	\N	2	0	2023-08-18 13:02:22	2023-08-18 13:02:22	Business Bay	25.00001951	55.02600309	64df339e48385_1692349342.jpg	1111111111111122222222222222222223	2028-08-18	Dubai	000000000000000000	Dubai	64df339e48474_1692349342.jpg
12	61	64df51e1a9d77_1692357089.jpg	64df51e1aae8c_1692357089.jpg	33669882	no	\N	2	0	2023-08-18 15:11:29	2023-08-18 15:11:29	Business Bay	31.55581283	74.27936342	64df51e1ab12c_1692357089.jpg	7373	2023-08-31	Dubai	95959	Dubai	64df51e1ab399_1692357089.jpg
13	64	64df906a7df3e_1692373098.jpg	64df906a7f16d_1692373098.jpg	2345987	yes	38	2	0	2023-08-18 19:38:18	2023-08-18 19:38:18	Business Bay	31.55588283	74.27935436	64df906a7f30a_1692373098.jpg	3333329999000	2023-08-31	Dubai	1248963	Dubai	64df906a7f4e7_1692373098.jpg
14	65	64e115c82e136_1692472776.jpg	64e115c82f202_1692472776.jpg	23574387	no	\N	2	0	2023-08-19 23:19:36	2023-08-19 23:19:36	Business Bay	31.55581540	74.27937347	64e115c82f399_1692472776.jpg	777777854	2023-08-20	Dubai	22258740	Dubai	64e115c82f53e_1692472776.jpg
15	66	64e1422608bf5_1692484134.jpg	64e1422609cf2_1692484134.jpg	3589655123	no	\N	2	0	2023-08-20 02:28:54	2023-08-20 02:28:54	Business Bay	31.55581283	74.27936912	64e1422609ec6_1692484134.jpg	65458854488	2023-08-31	Dubai	35896555	Dubai	64e142260a05f_1692484134.jpg
16	68	64f0f57c87aba_1693513084.jpg	64f0f57c89618_1693513084.jpg	336699852369852	no	\N	2	0	2023-09-01 00:18:04	2023-09-01 00:18:04	Business Bay	31.55581426	74.27938286	64f0f57c89731_1693513084.jpg	77889900	2023-09-30	Dubai	336699008523	Dubai	64f0f57c8982f_1693513084.jpg
17	69	64f2c26c99095_1693631084.jpg	64f2c26c9a659_1693631084.jpg	89949	yes	38	2	0	2023-09-02 09:04:44	2023-09-02 09:04:44	Business Bay	32.07691734	73.67632806	64f2c26c9b2b3_1693631084.jpg	hdvbnb	2024-09-02	Dubai	9889	Dubai	64f2c26c9b8c9_1693631084.jpg
18	71	64f97f343de9d_1694072628.jpg	64f97f34403a3_1694072628.jpg	898668	yes	38	2	0	2023-09-07 11:43:48	2023-09-07 11:43:48	Business Bay	31.49363000	74.41718135	64f97f344079c_1694072628.jpg	chvjvk	2023-09-07	Dubai	688686	Dubai	64f97f3440eb2_1694072628.jpg
19	83	6524e28de6bf9_1696916109.jpeg	6524e28de9c02_1696916109.jpeg	6464343	no	\N	1	0	2023-10-10 09:35:10	2023-10-10 09:35:10	Business Bay	33.56681960	73.13681211	6524e28dee5c5_1696916109.jpeg	hsjsjsjssj	2023-10-31	Dubai	6464345	Dubai	6524e28df0afd_1696916109.jpeg
20	86	652fdcc3943b7_1697635523.jpg	652fdcc395877_1697635523.jpg	257357835835	yes	38	2	0	2023-10-18 17:25:23	2023-10-18 17:25:23	Business Bay	25.18423453	55.25999364	652fdcc395af3_1697635523.jpg	36475886686	2024-10-19	Dubai	3573583	Dubai	652fdcc395c44_1697635523.jpg
21	87	6530e90ec03aa_1697704206.jpg	6530e90ec4574_1697704206.jpg	8698855478	no	\N	1	0	2023-10-19 12:30:06	2023-10-19 12:30:06	Business Bay	33.56687883	73.13681815	6530e90ec6c30_1697704206.jpg	090078602	2023-10-31	Dubai	86588	Dubai	6530e90ec7770_1697704206.jpg
22	88	6530ea4277d00_1697704514.jpg	6530ea42790ce_1697704514.jpg	8252486	no	\N	2	0	2023-10-19 12:35:14	2023-10-19 12:35:14	Business Bay	25.18424485	55.25997855	6530ea4279236_1697704514.jpg	ffyfyfy	2023-10-19	Dubai	868535	Dubai	6530ea42794a0_1697704514.jpg
24	90	653219be94891_1697782206.png	653219be95bc4_1697782206.png	74747474	no	\N	2	0	2023-10-20 10:10:06	2023-10-20 10:10:06	Business Bay	25.15285477	55.27328796	653219be95c8d_1697782206.png	54657657	2023-09-10	Dubai	7373733	Dubai	653219be95d4a_1697782206.png
25	91	65321b79c8213_1697782649.jpg	65321b79cd47b_1697782649.jpg	258075	no	\N	1	0	2023-10-20 10:17:29	2023-10-20 10:17:29	Business Bay	33.56679027	73.13682754	65321b79d0e89_1697782649.jpg	09876543113	2024-10-20	Dubai	86685	Dubai	65321b79d4c66_1697782649.jpg
26	92	65321e8b9a293_1697783435.png	65321e8b9b67f_1697783435.png	74747474	no	\N	2	0	2023-10-20 10:30:35	2023-10-20 10:30:35	Business Bay	25.15285477	55.27328796	65321e8b9b748_1697783435.png	6546546546	2023-09-10	Dubai	7373733	Dubai	65321e8b9b806_1697783435.png
27	94	6532209797d72_1697783959.jpg	653220979cbed_1697783959.jpg	25807511	no	\N	1	0	2023-10-20 10:39:19	2023-10-20 10:39:19	Business Bay	33.56678971	73.13682888	65322097a07b6_1697783959.jpg	123557800	2024-10-20	Dubai	25005	Dubai	65322097a42e3_1697783959.jpg
28	95	653221c64a399_1697784262.jpg	653221c657332_1697784262.jpg	36908	no	\N	1	0	2023-10-20 10:44:22	2023-10-20 10:44:22	Business Bay	33.56679110	73.13683055	653221c65d14b_1697784262.jpg	09876553321	2027-10-20	Dubai	8339085	Dubai	653221c662dfb_1697784262.jpg
29	96	653222cd654d4_1697784525.jpg	653222cd6a1f8_1697784525.jpg	846644	no	\N	1	0	2023-10-20 10:48:45	2023-10-20 10:48:45	Business Bay	33.56679222	73.13683257	653222cd6e036_1697784525.jpg	09876654322	2023-10-20	Dubai	54646	Dubai	653222cd71aad_1697784525.jpg
23	89	65316bb737686_1697737655.jpg	65316bb73900a_1697737655.jpg	0879654133	no	0	2	0	2023-10-19 21:47:35	2023-11-14 11:56:26	Business Bay	25.16402115	55.40154118	65316bb7399da_1697737655.jpg	0987654321	2024-10-19	Dubai	9632	Dubai	65316bb73a4bc_1697737655.jpg
32	99	65326b5f91e2b_1697803103.png	65326b5f93140_1697803103.png	74747474	no	\N	2	0	2023-10-20 15:58:23	2023-10-20 15:58:23	Business Bay	25.15285477	55.27328796	65326b5f93203_1697803103.png	4444444444444444	2023-09-10	Dubai	7373733	Dubai	65326b5f932c0_1697803103.png
33	100	65326d6830c55_1697803624.png	65326d6832085_1697803624.png	74747474	no	\N	2	0	2023-10-20 16:07:04	2023-10-20 16:07:04	Safa Park - Sheikh Zayed Rd - Al Safa - Dubai - United Arab Emirates	25.18543449	55.24619408	65326d6832145_1697803624.png	5436456546	2023-09-10	Dubai	7373733	Dubai	65326d68321fa_1697803624.png
34	101	6532770282920_1697806082.png	6532770283d0c_1697806082.png	74747474	no	\N	2	0	2023-10-20 16:48:02	2023-10-20 16:48:02	Safa Park - Sheikh Zayed Rd - Al Safa - Dubai - United Arab Emirates	25.185434492556674	55.24619407503102	6532770283ddb_1697806082.png	5464654655	2023-09-10	Dubai	7373733	Dubai	6532770283eb2_1697806082.png
35	102	6532779d706f5_1697806237.png	6532779d71a3f_1697806237.png	74747474	no	\N	2	0	2023-10-20 16:50:37	2023-10-20 16:50:37	Safa Park - Sheikh Zayed Rd - Al Safa - Dubai - United Arab Emirates	25.185434492556674	55.24619407503102	6532779d71b0c_1697806237.png	67658678	2023-09-10	Dubai	7373733	Dubai	6532779d71bce_1697806237.png
37	107	6538b1f8c9be8_1698214392.jpeg	6538b1f8cb081_1698214392.jpeg	323543	yes	38	2	0	2023-10-25 10:13:12	2023-10-25 10:13:12	3101 Marasi Dr - Business Bay - Dubai - United Arab Emirates	25.1842002	55.2599217	6538b1f8cb14f_1698214392.jpeg	2131221	2023-12-12	Dubai	24535	Dubai	6538b1f8cb202_1698214392.jpeg
30	97	65324db75196f_1697795511.jpeg	65324db752e6f_1697795511.jpeg	1354849	yes	38	2	0	2023-10-20 13:51:51	2023-11-11 14:13:09	Business Bay	25.18423301	55.25999565	65324db752f45_1697795511.jpeg	567181	2023-11-02	Dubai	125464	Dubai	65324db75300f_1697795511.jpeg
45	136	6550b59c8cdb2_1699788188.jpg	6550b59c8e377_1699788188.jpg	546649	no	\N	3	0	2023-11-12 15:23:08	2023-11-12 15:23:08	Business Bay	25.287773935101477	55.370356142520905	6550b59c8fde7_1699788188.jpg	shuei	2023-11-30	Dubai	54646	Dubai	6550b59c90411_1699788188.jpg
46	139	6551b8b100c10_1699854513.jpg	6551b8b101eef_1699854513.jpg	988999999	no	\N	2	0	2023-11-13 09:48:33	2023-11-13 09:48:33	Business Bay	22.4898608024688	88.37032970041037	6551b8b102047_1699854513.jpg	8753467888899	2023-11-30	Dubai	98789999	Dubai	6551b8b10219e_1699854513.jpg
47	144	65528bba6a12a_1699908538.jpg	65528bba6b818_1699908538.jpg	67643	no	\N	2	0	2023-11-14 00:48:58	2023-11-14 00:48:58	Business Bay	33.516402515878255	73.11082284897566	65528bba6c0ae_1699908538.jpg	08876537378383	2023-11-14	Dubai	9464	Dubai	65528bba6c66f_1699908538.jpg
39	112	653b4c043d956_1698384900.png	653b4c043edea_1698384900.png	74747474	no	\N	2	0	2023-10-27 09:35:00	2023-10-27 09:35:00	Safa Park - Sheikh Zayed Rd - Al Safa - Dubai - United Arab Emirates	25.185434492556674	55.24619407503102	653b4c043eebe_1698384900.png	5224789635	2023-09-10	Dubai	7373733	Dubai	653b4c043ef80_1698384900.png
40	114	653b64a618447_1698391206.jpg	653b64a61998a_1698391206.jpg	12337578	yes	106	2	0	2023-10-27 11:20:06	2023-10-27 11:20:06	Business Bay	25.184232104533816	55.25999128818512	653b64a61b766_1698391206.jpg	w536758686868	2024-10-27	Dubai	215484	Dubai	653b64a61ba2a_1698391206.jpg
41	128	654e8e0cee47c_1699646988.jpg	654e8e0cefb51_1699646988.jpg	1234	no	\N	1	0	2023-11-11 00:09:49	2023-11-11 00:09:49	Business Bay	33.51639217330388	73.11083860695362	654e8e0cf0c22_1699646988.jpg	098765432166	2023-11-30	Dubai	0987654321	Dubai	654e8e0cf1368_1699646988.jpg
42	129	654e8ed2aa0c2_1699647186.jpg	654e8ed2ab709_1699647186.jpg	1234	no	\N	1	0	2023-11-11 00:13:06	2023-11-11 00:13:06	Business Bay	33.51644025228788	73.11081446707249	654e8ed2abba7_1699647186.jpg	BB123	2023-11-30	Dubai	0987654321	Dubai	654e8ed2ac2d3_1699647186.jpg
43	130	654e8f650cf96_1699647333.jpg	654e8f650e515_1699647333.jpg	1234	no	\N	1	0	2023-11-11 00:15:33	2023-11-11 00:15:33	Business Bay	33.51644109087458	73.11082251369953	654e8f650f487_1699647333.jpg	0987654321T	2023-11-11	Dubai	0987654321	Dubai	654e8f650fbad_1699647333.jpg
44	132	654f4fb863c8a_1699696568.jpg	654f4fb866586_1699696568.jpg	6555855	no	\N	2	0	2023-11-11 13:56:08	2023-11-11 13:56:08	Business Bay	28.72357747728334	77.24529884755611	654f4fb867c84_1699696568.jpg	gffffffgg	2023-11-30	Dubai	555555	Dubai	654f4fb86933d_1699696568.jpg
36	104	6537723a52bb5_1698132538.jpg	6537723a5403e_1698132538.jpg	456789123	yes	38	2	0	2023-10-24 11:28:58	2023-11-11 14:10:41	Business Bay	31.489159443301777	73.09940099716187	6537723a54134_1698132538.jpg	DXB 450	2023-10-25	Dubai	456789	Dubai	6537723a54220_1698132538.jpg
31	98	65324ead021bd_1697795757.jpg	65324ead035fa_1697795757.jpg	463455787	no	0	2	0	2023-10-20 13:55:57	2023-11-14 12:28:56	Business Bay	25.19395649	55.23161754	65324ead0377d_1697795757.jpg	47882626	2023-11-24	Dubai	544654846	Dubai	65324ead038bb_1697795757.jpg
38	111	653b497733414_1698384247.jpg	653b4977348a6_1698384247.jpg	123848963	yes	38	2	0	2023-10-27 09:24:07	2023-11-14 12:37:10	Business Bay	25.184231497721463	55.259992964565754	653b497734a0a_1698384247.jpg	24677	2024-10-18	Dubai	122596	Dubai	653b497734bbe_1698384247.jpg
\.


--
-- Data for Name: driver_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.driver_types (id, type, created_at, updated_at) FROM stdin;
0	Individual	\N	\N
1	Company	\N	\N
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: faq; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.faq (id, title, description, active, created_at, updated_at, usertype) FROM stdin;
1	title1	description1	1	2023-10-09 10:00:00	2023-10-09 10:00:00	0
3	title3	<p>description3</p>	1	2023-10-09 10:00:00	2023-10-20 15:17:57	2
4	title4	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>	1	2023-10-09 10:00:00	2023-10-25 16:38:46	3
2	What is Timex?	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>	1	2023-10-09 10:00:00	2023-10-25 16:41:14	3
\.


--
-- Data for Name: help_request; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.help_request (id, subject, message, user_id, created_at, updated_at) FROM stdin;
1	terms-and-conditions	fdsgdf	74	2023-10-10 06:30:44	2023-10-10 10:30:44
2	submit here	messahe  here	74	2023-10-10 06:31:04	2023-10-10 10:31:04
3	submit here	messahe  here	77	2023-10-10 10:21:31	2023-10-10 14:21:31
4	test	Test message	73	2023-10-10 10:43:11	2023-10-10 14:43:11
5	yes	test mesage from driver apo	83	2023-10-10 21:19:37	2023-10-11 01:19:37
6	hello	messages	85	2023-10-18 12:11:37	2023-10-18 16:11:37
7	shipme t	okay	108	2023-10-25 12:42:34	2023-10-25 16:42:34
8	gg	test	97	2023-11-13 14:27:30	2023-11-13 18:27:30
9	test	test1234	97	2023-11-13 14:27:54	2023-11-13 18:27:54
\.


--
-- Data for Name: languages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.languages (language_id, language_name, lang_code, language_status, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_roles_table	1
2	2014_10_12_100000_create_users_table	1
3	2014_10_12_200000_create_password_resets_table	1
4	2014_10_12_300000_create_failed_jobs_table	1
5	2019_12_14_000001_create_personal_access_tokens_table	1
6	2023_03_02_093403_create_role_permissions_table	1
7	2023_03_05_171740_create_table_countries	1
8	2023_03_05_172109_create_table_country_languages	1
9	2023_03_13_065242_create_languages_table	1
10	2023_03_27_220811_create_pages_table	1
11	2023_03_28_231534_enable_postgis	1
12	2023_03_29_165153_add_coordinates_to_malls_table	1
13	2023_04_15_112135_add_socail_login_table	1
14	2023_04_15_134435_add_provider_to_users_table	1
15	2023_04_15_134617_add_avator_to_users_table	1
16	2023_04_15_172132_create_driver_details_table	1
17	2023_04_15_172206_create_truck_types_table	1
18	2023_04_15_172234_create_deligates_table	1
19	2023_04_15_172305_create_deligate_attributes_table	1
20	2023_04_15_172329_create_companies_table	1
21	2023_04_15_172402_create_bookings_table	1
22	2023_04_15_172442_create_booking_qoutes_table	1
23	2023_04_15_172522_create_booking_reviews_table	1
24	2023_04_15_172553_create_user_wallets_table	1
25	2023_04_15_172643_create_user_wallet_transactions_table	1
26	2023_04_15_184036_add_foreign_key_contraint_user_roles	1
27	2023_04_15_184120_add_foreign_key_contraint_driver_details	1
28	2023_04_15_190029_add_foreign_key_contraint_deligate_attributes	1
29	2023_04_15_190126_add_foreign_key_contraint_bookings	1
30	2023_04_15_190145_add_foreign_key_contraint_booking_qoutes	1
31	2023_04_15_190208_add_foreign_key_contraint_booking_reviews	1
32	2023_04_15_190256_add_foreign_key_contraint_user_wallets	1
33	2023_04_17_125531_create_driver_types_table	1
34	2023_04_17_193740_add_column_address_table	1
35	2023_04_18_192604_change_column_data_types	1
36	2023_04_18_193410_change_column_data_booking_qoutes_types	1
37	2023_04_19_140056_create_new_notifications_table	1
38	2023_04_19_165518_add_column_bookings_table	1
39	2023_04_19_165705_add_profile_image_users_table	1
40	2023_04_19_172013_add_commission_column_booking_qoutes	1
41	2023_04_19_184759_add_title_to_new_notificationa_table	1
42	2023_04_20_110505_add_column_deligate_attriibutes	1
43	2023_04_20_151756_add_column_is_admin_approved_in_booking_qoutes	1
44	2023_04_20_155036_add_location_to_driver_details_table	1
45	2023_04_21_140650_add_image_new_notifications	1
46	2023_04_24_200623_add_column_slug_deligates_table	1
47	2023_04_25_193443_add_column_total_amount_bookings	1
48	2023_04_26_120859_add_status_to_new_notifications_table	1
49	2023_04_27_110802_add_status_to_booking_reviews_table	1
50	2023_05_02_110342_add_paid_max_weight_in_tons_table	1
51	2023_05_16_092913_create_user_password_resets	1
52	2023_05_17_151418_add_column_user_table_is_admin_access	1
53	2023_05_17_160522_add_columns_lat_log_users	1
54	2023_05_17_224810_change_enum_values_in_reviews_table	1
55	2023_05_17_233635_add_column_booking_reviews_updated_by	1
56	2023_05_18_100623_add_colum_company_table_user_id	1
57	2023_05_18_151235_add_address_columns_users	1
58	2023_05_18_151349_add_documents_columns_driving_details	1
59	2023_05_19_121225_add_column_user_device_id_users	1
60	2023_05_19_121319_create_blacklist_tbale	1
61	2023_05_22_200422_create_shipping_methods_table	1
62	2023_05_22_225620_add_shipping_method_id_bookings	1
63	2023_05_22_234935_create_booking_charges_table	1
64	2023_05_24_052643_create_booking_status_trackings	1
65	2023_05_30_173001_add_license_expiry_companies	1
66	2023_05_31_080737_add_column_emirates_id_or_passport_back_driving_license	1
67	2023_05_31_084520_create_cities_table	1
68	2023_05_31_151832_add_column_received_amount_bookings	1
69	2023_06_01_203114_change_column_total_amount_type	1
70	2023_06_01_220716_change_customer_signature_column_type	1
71	2023_06_05_111123_remove_user_device_id_constraint	1
72	2023_06_05_125833_create_notification_users	1
73	2023_06_05_131348_change_new_notification_table	1
74	2023_06_06_130527_add_fcm_token_user	1
75	2023_06_07_104933_add_auth_columns_users	1
76	2023_07_20_144201_create_table_temp_users	1
77	2023_07_24_134806_create_booking_trucks	1
78	2023_07_24_135124_create_containers_table	1
79	2023_07_24_140240_create_booking_deligate_details	1
80	2023_07_24_143734_create_warehousing_details	1
81	2023_07_24_145213_create_accepted_qoutes	1
82	2023_07_24_164305_create_booking_containers	1
83	2023_07_24_170357_add_foreign_constraints_accepted_qoutes	1
84	2023_07_24_171012_add_foreign_constraints_warehousing_details	1
85	2023_07_24_171657_add_foreign_constraints_booking_deligate_details	1
86	2023_07_24_171801_add_foreign_constraints_booking_trucks	1
87	2023_07_24_171824_add_foreign_constraints_booking_containers	1
88	2023_07_26_165803_add_license_column	2
90	2023_07_26_204921_change_foreign_constratint_in_driver_details	3
91	2023_07_27_005234_add_shipping_method_id_bookings	4
93	2023_07_27_132246_create_booking_truck_alot	5
96	2023_07_28_170447_add_colum_number_of_pallet	6
97	2023_08_02_072124_add_booking_truck_id_booking_qoutes	7
98	2023_08_03_133823_add_total_qoutation_amount	8
99	2023_08_03_145327_change_booking_status_types	9
100	2023_08_03_160714_change_booking_status_tracking_types	10
101	2023_08_03_174106_add_booking_truck_id_accepted_qoutes	11
102	2023_08_04_093808_create_storage_types	12
103	2023_08_05_121629_create_addresses_table	13
104	2023_08_05_155103_add_colum_is_deleted_addresses	14
107	2023_08_06_231220_create_cart_bookings_table	15
108	2023_08_06_231456_create_booking_truck_carts	15
109	2023_08_07_150853_add_addresses_column_bookings	16
113	2023_08_07_214828_add_device_cart_id	17
114	2023_08_07_215045_change_gross_weight_datatype	17
115	2023_08_07_215252_change_gross_weight_datatype	17
116	2023_08_08_114635_create_booking_cart_deligate_details	18
117	2023_08_08_125111_change_column_datatype_total_volume_in_cbm	18
118	2023_08_09_104844_create_cart_warehousing_details	19
119	2023_08_10_111620_add_qouted_at_booking_qoutes	19
120	2023_08_15_211619_add_driver_id_booking_status_track	19
121	2023_08_15_221213_change_statues_tracking	19
122	2023_08_16_111730_add_booking_number_booking_carts	19
123	2023_08_16_193057_add_phone_columns_addresses	19
124	2023_08_16_195925_add_phone_bookings	19
125	2023_08_16_204553_add_addres_2_column_temp_users	19
126	2023_08_18_100543_change_phone_data_type	20
127	2023_08_19_163040_add_columns_accepted_qoutes	21
128	2023_10_04_111219_change_temp_users_add_more	22
129	2023_10_05_095040_change_users_add_country_city_ids	22
130	2023_10_10_080203_change_address_add_building	23
131	2023_10_10_085446_change_user_add_trade_license	24
132	2023_10_10_094153_create_app_settings	25
133	2023_10_10_101402_create_help_request	26
134	2023_10_10_103635_create_faq	27
135	2023_10_16_140200_change_users_add_temp_users	28
136	2023_10_17_101745_change_bookings_add_statuscode	29
137	2023_10_19_113028_change_booking_reviews_change_rate	30
138	2023_10_20_110511_create_settings	31
139	2023_10_20_140526_change_faq_add_usertype	32
140	2023_10_20_151316_change_faq_add_usertype	33
141	2023_10_20_163101_change_temp_users_change_lat_long	34
142	2023_10_24_082422_change_table_containers	35
143	2023_10_24_093927_change_boking_statustracking_add_statuccode	35
144	2023_10_24_100418_change_bookibgstatustracking_add_quote_id	35
145	2023_10_24_142859_change_bookings_add_parent_booking_id	36
146	2023_10_24_145548_change_booking_cart_add_parent_id	37
147	2023_10_26_155122_change_truck_types_add_is_container	38
148	2023_11_09_172443_collection_address_id	39
\.


--
-- Data for Name: notification_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notification_users (id, notification_id, user_id, created_at, updated_at) FROM stdin;
1	1	114	2023-11-13 14:49:28	2023-11-13 14:49:28
2	1	97	2023-11-13 14:49:28	2023-11-13 14:49:28
\.


--
-- Data for Name: notifications; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notifications (id, user_id, description, generated_by, generated_to, is_read, created_at, updated_at, title, image, status) FROM stdin;
1	\N	test	\N	\N	\N	2023-11-13 14:49:28	2023-11-13 14:49:28	test	6551ff389377a_1699872568.png	active
\.


--
-- Data for Name: pages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pages (id, title, status, slug, description, meta_title, meta_keyword, meta_description, lang_code, created_at, updated_at) FROM stdin;
1	About us	1	about-us	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Why do we use it?</h2>\r\n\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>	\N	\N	\N	en	2023-10-10 09:15:50	2023-10-10 09:15:50
5	Faq	1	faq	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>	\N	\N	\N	en	2023-10-10 10:58:51	2023-10-10 10:58:51
2	privacy policy	1	privacy-policy	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Why do we use it?</h2>\r\n\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>	\N	\N	\N	en	2023-10-10 09:17:16	2023-10-18 12:29:38
3	Terms and Conditions	1	terms-and-conditions	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Why do we use it?</h2>\r\n\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>&nbsp;</h2>	\N	\N	\N	en	2023-10-10 09:17:38	2023-10-18 16:10:26
6	Privacy policy	1	driver-privacy-policy	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>	\N	\N	\N	en	2023-10-20 08:55:24	2023-10-20 08:55:24
7	Terms and condition	1	driver-terms-conditions	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>	\N	\N	\N	en	2023-10-20 08:55:51	2023-10-20 08:55:51
4	Help	1	help	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>	\N	\N	\N	en	2023-10-10 10:07:19	2023-10-20 08:56:32
\.


--
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_resets (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, created_at, updated_at) FROM stdin;
2	App\\Models\\User	29	Personal Access Token	33f6b1a2dabf45960d693aa4c9aa99facd0d3e19694ed6d51f6db15a83535178	["*"]	\N	2023-08-04 22:48:36	2023-08-04 22:48:36
3	App\\Models\\User	30	Personal Access Token	d379039b9c3006c0575fec8c5337e2619cd575bc443a9c886484d23211416cb1	["*"]	\N	2023-08-04 23:01:20	2023-08-04 23:01:20
4	App\\Models\\User	31	Personal Access Token	d9a5b78d3bf57a6a70240650647072fee9964bc7d867530fcc3f69c63410bf9b	["*"]	\N	2023-08-04 23:10:11	2023-08-04 23:10:11
5	App\\Models\\User	32	Personal Access Token	1db2658a2f4e9352fdaee45ce024c4dcf6f07f774b81dd5b75fdcfe46cf870c2	["*"]	\N	2023-08-04 23:24:15	2023-08-04 23:24:15
6	App\\Models\\User	33	Personal Access Token	626b927445d6a4fda48e3a4838625046de395057f117c17d9c5e227c6b23522f	["*"]	\N	2023-08-04 23:40:04	2023-08-04 23:40:04
7	App\\Models\\User	34	Personal Access Token	64021ec022bdb7fe458e973690decfba7131d3db1d928e02316828613fb61343	["*"]	\N	2023-08-05 00:14:48	2023-08-05 00:14:48
10	App\\Models\\User	37	Personal Access Token	be6c58d2ab9f618d5602b3a4e27de02b5368e98ee6c6adf96c749fa550ea8baa	["*"]	\N	2023-08-05 00:32:36	2023-08-05 00:32:36
11	App\\Models\\User	16	16Raya Gentrysoftcube.web1@gmail.com	dbbb49c1a1d14396adb505449c56ccbd8370c700e185c36eb06c76aeb05216c3	["*"]	\N	2023-08-05 10:41:07	2023-08-05 10:41:07
12	App\\Models\\User	37	37Abdul Ghanighaniabro11@gmail.com	7ab52c5b145ecad2dfba4840fb2658e41114a174184b7e5d013229623deda753	["*"]	\N	2023-08-07 11:55:09	2023-08-07 11:55:09
13	App\\Models\\User	16	16Raya Gentrysoftcube.web1@gmail.com	e5f92f868a7d642318076d639a68f4e1486d10fe6c7b427e8737a861eb418716	["*"]	\N	2023-08-07 12:01:36	2023-08-07 12:01:36
14	App\\Models\\User	16	16Raya Gentrysoftcube.web1@gmail.com	f42ce3528df52871167ce06e5c5d0e949399aa48fe9ac5ca3161c4be6b8d7711	["*"]	\N	2023-08-07 12:17:43	2023-08-07 12:17:43
15	App\\Models\\User	16	16Raya Gentrysoftcube.web@gmail.com	78e063f477eb78f975efa58055733af63b5001c7bf741c28e0e9837fc3bc1aea	["*"]	\N	2023-08-08 10:05:19	2023-08-08 10:05:19
16	App\\Models\\User	39	Personal Access Token	24f15ce5d0707d18db0950aedf540dcb25f4cda65aa14ed6700d5ac6dd7fc203	["*"]	\N	2023-08-09 16:08:05	2023-08-09 16:08:05
17	App\\Models\\User	40	Personal Access Token	600e05fe9d31bf3764c5e7b66b271fa9ecd1f2ca85c2509b42c1ce85b92d60b0	["*"]	\N	2023-08-09 16:12:57	2023-08-09 16:12:57
18	App\\Models\\User	41	Personal Access Token	d3282a4fa0ef8fe9226ac252b25f71fcd836c4dddaccdd2ec254c2bafe4cd1d1	["*"]	\N	2023-08-09 16:14:01	2023-08-09 16:14:01
19	App\\Models\\User	42	Personal Access Token	0a2cae9abf107f648cde4628f29d45b9263f29de72398a6354bddf687f21d16f	["*"]	\N	2023-08-09 16:24:11	2023-08-09 16:24:11
20	App\\Models\\User	43	Personal Access Token	921cd89d80bfebba9087c32f0e5729cf3eaa1295423b3889b143d87e65ec402d	["*"]	\N	2023-08-10 21:14:35	2023-08-10 21:14:35
21	App\\Models\\User	43	43android testandroid_test01@gmail.com	521a851c06ffa998c7048b8f454deba33ef76c32fa77acc7aac1d14a305cd1a2	["*"]	\N	2023-08-10 21:16:41	2023-08-10 21:16:41
22	App\\Models\\User	44	Personal Access Token	f378cb4762643aea456b3b417e3fad1c7c64d305a2fc66ac4668ffef7f79722b	["*"]	\N	2023-08-12 09:15:57	2023-08-12 09:15:57
23	App\\Models\\User	44	44Android Test2android_test1@gmail.com	1ae298de80903b3ac7027135d4fe5bd4fc84601ded5f0b770b97707b084f3045	["*"]	\N	2023-08-12 09:17:53	2023-08-12 09:17:53
24	App\\Models\\User	44	44Android Test2android_test1@gmail.com	6c71a32ff1971c572796ca18f60c70807413bcf4ae56fd431461132f4b1c0348	["*"]	\N	2023-08-12 09:20:44	2023-08-12 09:20:44
25	App\\Models\\User	44	44Android Test2android_test1@gmail.com	21349af3ce7ccd0fe1b92be63701720a81dd41facf679a0fc8b017819fcd0eab	["*"]	\N	2023-08-12 09:26:28	2023-08-12 09:26:28
26	App\\Models\\User	44	44Android Test2android_test1@gmail.com	f7f906d881cc47fee4c0b906b7f4594c52c37e48c81b040f5845bef3b5bfab57	["*"]	\N	2023-08-12 09:38:47	2023-08-12 09:38:47
27	App\\Models\\User	45	Personal Access Token	f99878792b00a9b3038ec025fed21c8ae09310d18053da87e1485569fde37014	["*"]	\N	2023-08-12 10:46:45	2023-08-12 10:46:45
28	App\\Models\\User	45	45company testandroid_test2@gmail.com	8e199263a0f9320361b39a046187b061956c71d216b9f8ddb51b98091efb479b	["*"]	\N	2023-08-12 10:47:22	2023-08-12 10:47:22
29	App\\Models\\User	46	Personal Access Token	506c5970a25a78f410902271da80de9f134411cb379a8534984e4cfe8fa6c4d1	["*"]	\N	2023-08-12 14:51:10	2023-08-12 14:51:10
30	App\\Models\\User	44	44Android Test2android_test1@gmail.com	f0226a361de0a50d57fab18bf89bb33ae2bca0b29310ae5a3390523d9600e658	["*"]	\N	2023-08-12 21:31:10	2023-08-12 21:31:10
31	App\\Models\\User	44	44Android Test2android_test1@gmail.com	418cd0512c923b7dcb93f9002ff4b1540d409711770507347b6704c01b26617c	["*"]	\N	2023-08-13 11:59:10	2023-08-13 11:59:10
32	App\\Models\\User	44	44Android Test2android_test1@gmail.com	0c6fd422750d325eef4c215a3df94cbf69d3b7b2f7fad77d1302327d3b71425b	["*"]	\N	2023-08-13 12:00:37	2023-08-13 12:00:37
33	App\\Models\\User	44	44Android Test2android_test1@gmail.com	8f31fec30b3eb439ce672d86fdb218d75c01e6c2e929da415bf48051fdaf7c0a	["*"]	\N	2023-08-14 10:04:44	2023-08-14 10:04:44
34	App\\Models\\User	37	37Abdul Ghanighaniabro11@gmail.com	97ee90369c9f6cd499c0aef89310797a49050d0af8061cb53d1e5a77ee2d3a2a	["*"]	\N	2023-08-15 09:14:18	2023-08-15 09:14:18
35	App\\Models\\User	44	44Android Test2android_test1@gmail.com	22c04809a7ec0aed2f1edc305246564324e848efaa5706c9aaacb1c02407e787	["*"]	\N	2023-08-16 05:54:41	2023-08-16 05:54:41
36	App\\Models\\User	44	44Android Test2android_test1@gmail.com	9a7e6a8261ceeb1b743e21f79baba25e5930ee141f0e933d1c588b84423ff5d2	["*"]	\N	2023-08-16 05:55:47	2023-08-16 05:55:47
37	App\\Models\\User	44	44Android Test2android_test1@gmail.com	bbfca9a74bc63ea2c7692945d165f46735d3b05ac4d6f6830d1f67ff973dc547	["*"]	\N	2023-08-16 08:21:31	2023-08-16 08:21:31
38	App\\Models\\User	44	44Android Test2android_test1@gmail.com	f1bd6e895ad236510cb041b8ecf3997a1e19a6b70a255e4e6b828ada582aa419	["*"]	\N	2023-08-16 08:28:21	2023-08-16 08:28:21
39	App\\Models\\User	16	16Raya Gentrysoftcube.web@gmail.com	5cccf890a36efa3b3aed2755ba8c06d39799b4ff3bf5705801297fdd12db3f97	["*"]	\N	2023-08-16 09:01:09	2023-08-16 09:01:09
40	App\\Models\\User	44	44Android Test2android_test1@gmail.com	007752d97b3c2e29fc24f547584d646442619cb49232aafc9a031717c524961f	["*"]	\N	2023-08-16 09:13:33	2023-08-16 09:13:33
41	App\\Models\\User	44	44Android Test2android_test1@gmail.com	593a3badf92a906af35e853afac314d14f43352d254fc096d9dc082b6dedcdf4	["*"]	\N	2023-08-16 20:29:48	2023-08-16 20:29:48
42	App\\Models\\User	37	37Abdul Ghanighaniabro11@gmail.com	41bb8dc8ed08f76c404247fb7adcaed387f0f1498d667071d6979c2e2b9829f0	["*"]	\N	2023-08-17 00:15:11	2023-08-17 00:15:11
43	App\\Models\\User	44	44Android Test2android_test1@gmail.com	b4dcbe28798eba361e6f55f2041a0113bdd3014bc7b646037d1bba825e1f6160	["*"]	\N	2023-08-17 08:41:52	2023-08-17 08:41:52
44	App\\Models\\User	47	Personal Access Token	93df40f418ab81d45678dcf7a0912fba3bd05d523f3e598f2c845a69bf2e76d1	["*"]	\N	2023-08-17 18:50:05	2023-08-17 18:50:05
45	App\\Models\\User	44	44Android Test2android_test1@gmail.com	b2f0005fa8f5298e706b878fd9bb2ce3cf2aab78fd66d6071f54a4ac4b0e4638	["*"]	\N	2023-08-17 19:54:19	2023-08-17 19:54:19
46	App\\Models\\User	44	44Android Test2android_test1@gmail.com	7676971b88004de6a4fa06b6cb2f3bfc94e2a5a0f76a61b7aaa042ec1b254c95	["*"]	\N	2023-08-17 20:24:15	2023-08-17 20:24:15
47	App\\Models\\User	48	Personal Access Token	901189625be49b7081b3e7b070b8c43b576b3c1bbbc6f75bfcab30c1d2681c9d	["*"]	\N	2023-08-17 22:06:04	2023-08-17 22:06:04
48	App\\Models\\User	44	44Android Test2android_test1@gmail.com	4c0ffa5595b796a981be90a7c82919ecc9b924e62324ae1642f179d22658036d	["*"]	\N	2023-08-17 22:20:17	2023-08-17 22:20:17
49	App\\Models\\User	49	Personal Access Token	da2eabf2707fd86f541d770519159d6113e97937918f43480a70f83e8ba65166	["*"]	\N	2023-08-17 23:33:04	2023-08-17 23:33:04
50	App\\Models\\User	50	Personal Access Token	27ceea1ce3f576923dc45aaa8957ee05a9a25e1fa7dbb3fa487e946fad79812d	["*"]	\N	2023-08-17 23:46:58	2023-08-17 23:46:58
51	App\\Models\\User	51	Personal Access Token	3c2ed1300493d28f01f9fe1ae517f83ba707587a0b053c6931eca8e62b67f045	["*"]	\N	2023-08-18 01:02:22	2023-08-18 01:02:22
52	App\\Models\\User	52	Personal Access Token	ecc00382cff5a309a956941191ea916838d7a72ddbb5edc204dfbd029c4afcc7	["*"]	\N	2023-08-18 01:44:02	2023-08-18 01:44:02
53	App\\Models\\User	53	Personal Access Token	b0292cee0490e4730362755ccd44444b3df6242d41c8d33a2e202d21ad4c95bc	["*"]	\N	2023-08-18 08:28:14	2023-08-18 08:28:14
54	App\\Models\\User	54	Personal Access Token	b107c11513cf6ac24b68b0601f639567b7c91fd1c92d721330963befe246fc47	["*"]	\N	2023-08-18 08:29:29	2023-08-18 08:29:29
55	App\\Models\\User	55	Personal Access Token	b75b82eb26a15414dbe7ae23f9d9b9d97e7773f1d3caffb34c9ccb74c6dad06b	["*"]	\N	2023-08-18 08:30:31	2023-08-18 08:30:31
56	App\\Models\\User	56	Personal Access Token	0f59eab1aeeae1eebb1a7c54364be502bf9ef039b7484b58628817b590783f4d	["*"]	\N	2023-08-18 08:34:23	2023-08-18 08:34:23
57	App\\Models\\User	57	Personal Access Token	c6d2ffd9e15ac437a249ea161b18a761b7bd3d989b045ef3431472d388237497	["*"]	\N	2023-08-18 09:09:12	2023-08-18 09:09:12
58	App\\Models\\User	57	57timerxtimerx01@gmail.com	6b459917bca717a5d5408ab2de62cadf548e0f75db18dee2cf82168e3bb098ff	["*"]	\N	2023-08-18 09:32:55	2023-08-18 09:32:55
59	App\\Models\\User	16	16Raya Gentrysoftcube.web@gmail.com	efea8055cd4f0c79ffccf3ab196c4e338d09ae2bfb406926ddc38c0107e49b02	["*"]	\N	2023-08-18 10:22:19	2023-08-18 10:22:19
60	App\\Models\\User	37	37Abdul Ghanighaniabro11@gmail.com	e352087d1c23e6003aef20b221c032456467179bb8de58105c666dcc51913575	["*"]	\N	2023-08-18 11:32:48	2023-08-18 11:32:48
61	App\\Models\\User	37	37Abdul Ghanighaniabro11@gmail.com	9e2027601f5f797e25da0f09a9303fa3a3ff382964d8b682de060aacfef62b34	["*"]	\N	2023-08-18 11:35:50	2023-08-18 11:35:50
62	App\\Models\\User	37	37Abdul Ghanighaniabro11@gmail.com	5bb1d458ae378bdec8770cc3c9586f031fd24b70f348785dcf52cc45dfff51cb	["*"]	\N	2023-08-18 11:52:50	2023-08-18 11:52:50
63	App\\Models\\User	58	Personal Access Token	cce9a13007d58ee1b3a128de5110ac039f636633af5b475288d84bdf2501aaf5	["*"]	\N	2023-08-18 12:27:50	2023-08-18 12:27:50
64	App\\Models\\User	58	58Muzammalpyxiscoding@gmail.com	06489cd752381d3c6f9b43660d76d5eb5269dcab2ee113ea47025d0af828e401	["*"]	\N	2023-08-18 12:39:19	2023-08-18 12:39:19
65	App\\Models\\User	59	Personal Access Token	55740ad1542470524b82a50052a803366d9e363c07d6817e4c50d3c2787d45e6	["*"]	\N	2023-08-18 13:02:22	2023-08-18 13:02:22
66	App\\Models\\User	59	59Devikadevikasr1995@gmail.com	6acf1222573d16950e6dd3b3ba6b23b62c957f248b7e60465e71241ca1e85410	["*"]	\N	2023-08-18 13:05:27	2023-08-18 13:05:27
67	App\\Models\\User	44	44Android Test2android_test1@gmail.com	1a802a26f3cfdaa8faa4d410009fe12b34df97cd51e7f9fbca9c4644d8253c69	["*"]	\N	2023-08-18 14:12:29	2023-08-18 14:12:29
68	App\\Models\\User	44	44Android Test2android_test1@gmail.com	20e451e4a78b891a5126e5e67c58244291ddac3a4a5508e10632a4e63e88b801	["*"]	\N	2023-08-18 14:37:03	2023-08-18 14:37:03
69	App\\Models\\User	44	44Android Test2android_test1@gmail.com	cca62e65b3892e399f33ec3abd03f0ab97f3544cdc5079931959cd4b5d4e847c	["*"]	\N	2023-08-18 14:37:59	2023-08-18 14:37:59
70	App\\Models\\User	60	Personal Access Token	f9123a5365730291af95f228823bd0b7e4c02b36d5811b1197efc28d4144d611	["*"]	\N	2023-08-18 14:39:42	2023-08-18 14:39:42
71	App\\Models\\User	60	60android dxbandroid_test3@gmail.com	6ddb4ea863c123bc15ed76e25090171024988ff4bb480e2946b3f7ff3a8f31a7	["*"]	\N	2023-08-18 14:44:37	2023-08-18 14:44:37
72	App\\Models\\User	61	Personal Access Token	826b01f125474cca2993d2bd7e21b30f1a4d11b8229c86ebaec0f6105281f992	["*"]	\N	2023-08-18 15:11:29	2023-08-18 15:11:29
73	App\\Models\\User	62	Personal Access Token	cb0e7cef22a85524f13e26a9df0a9db005be59264188c6351c73d4c1c4307d0d	["*"]	\N	2023-08-18 15:53:35	2023-08-18 15:53:35
74	App\\Models\\User	63	Personal Access Token	00e1c173d7cff3c4e6ac301d5ef0a89a964065fb1ef2080480eccc60a04b871b	["*"]	\N	2023-08-18 15:55:13	2023-08-18 15:55:13
75	App\\Models\\User	63	63Android dxbandroid_test6@gmail.com	d77915fdef9943e6536adc40448f711651503de0f4fe927045606c8fc60f3905	["*"]	\N	2023-08-18 15:55:53	2023-08-18 15:55:53
76	App\\Models\\User	64	Personal Access Token	311b50a08db9a87cccff984462ec0878e154fb16f8833c0bcb01a805e85fbd4f	["*"]	\N	2023-08-18 19:38:18	2023-08-18 19:38:18
77	App\\Models\\User	44	44Android Test2android_test1@gmail.com	570275280199a423950d8948f6b6652319bc43cf59d9f5c5f67bfe838e784b33	["*"]	\N	2023-08-19 17:07:35	2023-08-19 17:07:35
78	App\\Models\\User	37	37Abdul Ghanighaniabro11@gmail.com	51bf04643005b388a624fe2bfc089257be2658340ed41a296f5a486bfb2ad257	["*"]	\N	2023-08-19 22:24:37	2023-08-19 22:24:37
79	App\\Models\\User	65	Personal Access Token	bfda8c9181a5f23e5df70c521d50c0db8acb0bb9dff6009479ba0f7051a0c33d	["*"]	\N	2023-08-19 23:19:36	2023-08-19 23:19:36
80	App\\Models\\User	65	65Muzammal Faridfaridmuzammal175@gmail.com	0fe3dbd2c4f56b5bd43a62481dff1717d9119c87b6172bb32384c10037801dba	["*"]	\N	2023-08-19 23:20:07	2023-08-19 23:20:07
81	App\\Models\\User	65	65Muzammal Faridfaridmuzammal175@gmail.com	0c0dbeca764bf0b079baeae6aac41aab73ece116915c1aa4de3153f93d279c80	["*"]	\N	2023-08-19 23:22:48	2023-08-19 23:22:48
82	App\\Models\\User	66	Personal Access Token	5a7f668ddc7cb30082924b33152fde93793cd50a553d1d9aec994115b0a34579	["*"]	\N	2023-08-20 02:28:54	2023-08-20 02:28:54
83	App\\Models\\User	66	66muzammal Faridfarid@gmail.com	4bd609136a393060873a63e125b2ae88c3fc80f410bb0459e9fe6052a89101a7	["*"]	\N	2023-08-20 02:29:31	2023-08-20 02:29:31
84	App\\Models\\User	66	66muzammal Faridfarid@gmail.com	1467efa593e8c8ca98d1f888837f0763945c360df695f80f1a28c110df876c44	["*"]	\N	2023-08-20 02:41:30	2023-08-20 02:41:30
85	App\\Models\\User	66	66muzammal Faridfarid@gmail.com	211d22fc72cb44b3873f096722358c5c42bc89cc6fd45188aab8c0f4baab3a05	["*"]	\N	2023-08-21 14:36:44	2023-08-21 14:36:44
86	App\\Models\\User	66	66muzammal Faridfarid@gmail.com	46d7ec0f966f0f38837bad2873adcaa863d56c515bc98ee5caa67557f4ebedfe	["*"]	\N	2023-08-21 16:21:09	2023-08-21 16:21:09
87	App\\Models\\User	67	Personal Access Token	da160552833e8679be1528a17e34216e04572f8109c660687b4a1ae50b61621d	["*"]	\N	2023-08-21 20:33:41	2023-08-21 20:33:41
88	App\\Models\\User	67	67Android Test5android.testing5@gmail.com	b9afe6dc6bb027e0f1601bf361f694a82e9da302c47d108b5ef27588f0b10c1a	["*"]	\N	2023-08-21 20:34:40	2023-08-21 20:34:40
89	App\\Models\\User	44	44Android Test2android_test1@gmail.com	1bc97bc1cf4e43ecf5e91235741208de08f37dfbc04ca9cdf10900500df5f4ec	["*"]	\N	2023-08-24 18:43:32	2023-08-24 18:43:32
90	App\\Models\\User	68	Personal Access Token	7d168cb1e15794077f9f29bd5a3d48fda2a09a6b144784acf71a0f5fb135658b	["*"]	\N	2023-09-01 00:18:04	2023-09-01 00:18:04
91	App\\Models\\User	69	Personal Access Token	ac81b68ca99f64df4491e585aef873dfa52b636fd13f55e1b5ec6d12982de954	["*"]	\N	2023-09-02 09:04:44	2023-09-02 09:04:44
92	App\\Models\\User	70	Personal Access Token	e2e2325ae834b297bcf13b28f24e9deea4b6a1dfaf920f44ebf2b20424aacc53	["*"]	\N	2023-09-04 11:56:08	2023-09-04 11:56:08
93	App\\Models\\User	70	70DXdx@yopmail.com	4fdc7217a68ba734d28b5a5d57e4d53e9f4c9969c4ae6c68b948fcde4332691c	["*"]	\N	2023-09-04 11:57:12	2023-09-04 11:57:12
94	App\\Models\\User	70	70DXdx@yopmail.com	40cdeb595d7f996cbc0f52389144c8ac964826356b707b3697bb3c35c855d069	["*"]	\N	2023-09-04 12:01:18	2023-09-04 12:01:18
95	App\\Models\\User	44	44Android Test2android_test1@gmail.com	05bc2e590c7eba8d00227ee6c1b571189ffcd6e394848dd89f8ff9d2452ce543	["*"]	\N	2023-09-04 21:32:47	2023-09-04 21:32:47
96	App\\Models\\User	44	44Android Test2android_test1@gmail.com	51282e13361341d5db10e8232d2e7c4094472d1097f5da56dbd61cc88600fa6e	["*"]	\N	2023-09-04 22:03:57	2023-09-04 22:03:57
97	App\\Models\\User	71	Personal Access Token	df154bff95da42e11c158dc9e72807d80994f2a79cf9e6530d52b69cf744f246	["*"]	\N	2023-09-07 11:43:48	2023-09-07 11:43:48
98	App\\Models\\User	71	71android testerandroid_driver12@hotmail.com	a4b8ac9442b59d9f4c799103721aef15f9bd21738e61b222bb93c439fcd9c589	["*"]	\N	2023-09-07 11:44:31	2023-09-07 11:44:31
99	App\\Models\\User	72	Personal Access Token	3f2f5cd0762d9e7f68f3942a468809e92963726ad255eb4425e415eaab78bdbe	["*"]	\N	2023-10-07 08:36:09	2023-10-07 08:36:09
100	App\\Models\\User	72	72Binsha Mbdeepika@gmail.com	b3773d05a734441228f6597180a35cbecde1527da5ec70ca805016b1a4be5b47	["*"]	\N	2023-10-07 08:36:10	2023-10-07 08:36:10
101	App\\Models\\User	73	Personal Access Token	5571038874c05d44cae2be99dffdfd5a744e45e31942308dc4713dc6309cca9f	["*"]	\N	2023-10-07 09:19:53	2023-10-07 09:19:53
102	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	a5306ced3c6cfd9815b45fd2ef8842f96cd148c0dd50934c1bda138c2b2649cf	["*"]	\N	2023-10-07 09:20:36	2023-10-07 09:20:36
103	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	28efa1fc9ae145c9e9ad5a1ee289f9de6e0f60a17621fbe8358b22a1ea7cb84f	["*"]	\N	2023-10-07 09:22:47	2023-10-07 09:22:47
104	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	b9acc0384c7cc689b1e961d3f94a2ebdd0f99b13a68df3bd6740a4806bf7db14	["*"]	\N	2023-10-07 09:27:48	2023-10-07 09:27:48
105	App\\Models\\User	74	Personal Access Token	f593238946d2b70c262680757ab428f4e5bd2e11ee710bf5a6d955aa3dfd03d5	["*"]	\N	2023-10-07 10:17:16	2023-10-07 10:17:16
106	App\\Models\\User	74	74Binsha Mbbinshambrs@gmail.com	4be19201e57226c963be388b833d4303686aa2b1bdb8f0bbe0572516a1dd1c5e	["*"]	\N	2023-10-07 10:17:17	2023-10-07 10:17:17
107	App\\Models\\User	74	74Binsha Mbbinshambrs@gmail.com	3d401df51a5520738d22568a33b3fbf5edf2b3a570de2f88d63cca3e6fc6688d	["*"]	\N	2023-10-07 10:17:26	2023-10-07 10:17:26
108	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	5592d41e5d058c539ecd7d2321c60a7426f572248dd0643777d42031e9d205c0	["*"]	\N	2023-10-07 11:45:47	2023-10-07 11:45:47
109	App\\Models\\User	75	Personal Access Token	deb52a97a355587a92bead8584c42cbd72cc60459a5fc68fe70586993e5ba9d3	["*"]	\N	2023-10-07 14:07:53	2023-10-07 14:07:53
110	App\\Models\\User	75	75Mahima Cherianmahima@dxbusinessgroup.com	edef8a2ba32c27ead15117ac278444ba6459b76864bf28be3137068d9d762a68	["*"]	\N	2023-10-07 14:08:11	2023-10-07 14:08:11
111	App\\Models\\User	75	75Mahima Cherianmahima@dxbusinessgroup.com	f43f157581b2f2856f14e214776f3172ef618b38b7bac12b91885959a35dace9	["*"]	\N	2023-10-07 17:47:40	2023-10-07 17:47:40
112	App\\Models\\User	75	75Mahima Cherianmahima@dxbusinessgroup.com	c7272a4d4dfcbeb52fc4dbe2a457164df62918e7101036036fe25da1050a69da	["*"]	\N	2023-10-07 17:55:48	2023-10-07 17:55:48
113	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	b3f95cf6a57acebfc7bb8c0e4dcef32c3dc3447b19f7c1303dfff210aab9035a	["*"]	\N	2023-10-09 08:50:10	2023-10-09 08:50:10
114	App\\Models\\User	76	Personal Access Token	8a15745f5972bf36080e9f259552aec63679735b0880dec785065fd11a6afafa	["*"]	\N	2023-10-09 08:51:03	2023-10-09 08:51:03
115	App\\Models\\User	76	76tesDevtest@gmail.con	281915da50bfa49e9c54f19a2e4cb0fca7c4fc26379aa226a1444c042f8e13a2	["*"]	\N	2023-10-09 08:51:03	2023-10-09 08:51:03
116	App\\Models\\User	76	76tesDevtest@gmail.con	2eec157cb69fefb23a31408860ca2e93cb657539f0867bb4d6da508f15940d95	["*"]	\N	2023-10-09 08:51:03	2023-10-09 08:51:03
117	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	01e9561bc6a750fb1533f6cbbb1af75005051c745ddcb1262a08276c6cf9cc6f	["*"]	\N	2023-10-09 08:52:41	2023-10-09 08:52:41
118	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	a955602e56aab11ae385e583f97b7b742fdb99a7fa4532a56a40b9145b0baa56	["*"]	\N	2023-10-09 09:51:05	2023-10-09 09:51:05
119	App\\Models\\User	74	74Binsha Mbbinshambrs@gmail.com	6726673eb8ecbd583f57f462d57c36f9cf6a16f6fa2f66cf771ad42f92dbf388	["*"]	\N	2023-10-09 15:29:47	2023-10-09 15:29:47
120	App\\Models\\User	74	74Binsha Mbbinshambrs@gmail.com	0f22cb893c4da6e8d302906385bec799bbe8097bb3f2543ec68876b142bc737b	["*"]	\N	2023-10-09 15:29:57	2023-10-09 15:29:57
121	App\\Models\\User	77	Personal Access Token	7e5f403aec02e548c9f11717ce86450821bf25f4edccd75d354c6fea7e991ea6	["*"]	\N	2023-10-09 15:58:48	2023-10-09 15:58:48
122	App\\Models\\User	77	77testDevtest2@gmail.com	97ba9d782bc150c3224a465eb2dbb6e69d564d20daf5830d7e3d646bce20e690	["*"]	\N	2023-10-09 15:58:49	2023-10-09 15:58:49
123	App\\Models\\User	77	77testDevtest2@gmail.com	f5fb78d8d9292f17d47e1ba68515091098b0ad3e4bb4ca0666b9abdd5a7bdc5f	["*"]	\N	2023-10-09 15:58:49	2023-10-09 15:58:49
124	App\\Models\\User	77	77testDevtest2@gmail.com	ef32c9552d8c07e126988ee0f07d48a8a78de64a3e2cd73ff863a06789bbbf99	["*"]	\N	2023-10-09 15:59:09	2023-10-09 15:59:09
125	App\\Models\\User	78	Personal Access Token	87a5501f29aa2e9720e721ff17e8de7f78c731874327ad75d55d2b29326a5b52	["*"]	\N	2023-10-09 17:06:38	2023-10-09 17:06:38
126	App\\Models\\User	78	78Perlsperls@yopmail.com	6e3af16069d0b5c9b644e1ce7a605fea92185b4455ff60a6712275722857898d	["*"]	\N	2023-10-09 17:06:38	2023-10-09 17:06:38
127	App\\Models\\User	78	78Perlsperls@yopmail.com	04ac04f286fcf076cd2ac714dc4b8ff89496115df26740dd5daa50c48cec4cd3	["*"]	\N	2023-10-09 17:06:38	2023-10-09 17:06:38
128	App\\Models\\User	79	Personal Access Token	51f5b98bcd159ed3786be26788092cda61b82ef58924328b547578320a07d0e4	["*"]	\N	2023-10-09 17:08:05	2023-10-09 17:08:05
129	App\\Models\\User	79	79FRPfep@yopmail.com	d968d7c745ddeb74248b4ef1a614e93feeab038ec58f77443445881b0aa2bbc4	["*"]	\N	2023-10-09 17:08:06	2023-10-09 17:08:06
130	App\\Models\\User	79	79FRPfep@yopmail.com	89af7178f1ae618eac44b5d7d01b33f04132250645a50befba3addd775008267	["*"]	\N	2023-10-09 17:08:06	2023-10-09 17:08:06
131	App\\Models\\User	78	78Perlsperls@yopmail.com	8e9ac8c989e5159a7067bfd67b77822aea38f0deb3a23a85caa44940a48da8ae	["*"]	\N	2023-10-09 17:08:25	2023-10-09 17:08:25
132	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	9072002770cb398e321914c68f3f8e7aab7d766cd3812bef4199f872fba2880a	["*"]	\N	2023-10-09 17:22:34	2023-10-09 17:22:34
133	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	48c85f9b4ecb83a6373e8ff8507c69341855445fda2c9123186c372bb3042228	["*"]	\N	2023-10-09 17:25:41	2023-10-09 17:25:41
134	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	efec43c308daae4ab892ce2f10d4ffe9a29f7769c489301e40b425e9b8edf969	["*"]	\N	2023-10-09 17:28:09	2023-10-09 17:28:09
135	App\\Models\\User	77	77testDevtest2@gmail.com	5c15cbff50497249461e7e6f8bf4936a33dbd5dcc879384e2b31ee8e38086b43	["*"]	\N	2023-10-09 17:31:52	2023-10-09 17:31:52
136	App\\Models\\User	77	77testDevtest2@gmail.com	e0b0fc3878c812c74cc59f3e2ac7c3534aa42d80427f366cdcbc4a9a06b19afb	["*"]	\N	2023-10-09 22:16:33	2023-10-09 22:16:33
137	App\\Models\\User	77	77testDevtest2@gmail.com	d778f86d6fa9496c9985445f3eedb5fc7957e5ac7712842d5739a18fb3bb5214	["*"]	\N	2023-10-09 22:19:09	2023-10-09 22:19:09
138	App\\Models\\User	77	77testDevtest2@gmail.com	9333ba31b595628a6935695abc32a5de30d348a2d5c7e74592a205d43dffd8a3	["*"]	\N	2023-10-09 23:55:19	2023-10-09 23:55:19
139	App\\Models\\User	77	77testDevtest2@gmail.com	8d7ff6e5cb0a8f44eaa001e5aeed5a60ce4112d34e67760989a6ab7f0071c3c0	["*"]	\N	2023-10-10 00:12:24	2023-10-10 00:12:24
140	App\\Models\\User	77	77testDevtest2@gmail.com	769e975526fa68cf9d97cf286d74b1ef4e76bc9e047dca3226e01a82e53ef3f8	["*"]	\N	2023-10-10 00:31:58	2023-10-10 00:31:58
141	App\\Models\\User	80	Personal Access Token	edc48ca51b21e46f9f448bad851e812fcdbb410da5767c5f0c12e09036fab252	["*"]	\N	2023-10-10 01:32:27	2023-10-10 01:32:27
142	App\\Models\\User	80	80test threetest3@gmail.com	574576b6be9180aac2ec20d48674471316685dc8139219212118406944e6a8d5	["*"]	\N	2023-10-10 01:32:28	2023-10-10 01:32:28
143	App\\Models\\User	80	80test threetest3@gmail.com	f18ca03004394591ef1b30a6742121e0d246c8282092bc379d2739037c022f66	["*"]	\N	2023-10-10 01:32:28	2023-10-10 01:32:28
144	App\\Models\\User	81	Personal Access Token	d27a64f0d0f06daef2d658a0f7e557c3ce5f4823728ba72cab3287954e6d895e	["*"]	\N	2023-10-10 01:43:06	2023-10-10 01:43:06
145	App\\Models\\User	81	81test fourtest4@gmail.com	67e487b37b6a9d9c967de3e52df4ef7634d87ae1d2ae5fa3eaf6549f067a42a9	["*"]	\N	2023-10-10 01:43:07	2023-10-10 01:43:07
146	App\\Models\\User	81	81test fourtest4@gmail.com	767b33781beb3f3d7553834d54aa01865472243e3ab28b1a1bfdba91fa8eedc7	["*"]	\N	2023-10-10 01:43:07	2023-10-10 01:43:07
147	App\\Models\\User	82	Personal Access Token	31514a38d8516da619b0708a1d63e0c7c83631171644c505a72719b3680d15be	["*"]	\N	2023-10-10 01:48:31	2023-10-10 01:48:31
148	App\\Models\\User	82	82test fivetest5@gmail.com	7de48cbaa1e8b8e1d8ef38961c9a07b73333167cb6c6660861aab406ff3c8064	["*"]	\N	2023-10-10 01:48:32	2023-10-10 01:48:32
149	App\\Models\\User	82	82test fivetest5@gmail.com	101063ea3bfd8c799afd26acef35828a7d4e487512c09d1935cc87857c0ff246	["*"]	\N	2023-10-10 01:48:32	2023-10-10 01:48:32
150	App\\Models\\User	77	77testDevtest2@gmail.com	ff006dca98a218e047891fe7369e64faf11493956751fbebb37848cbfb7d0c2d	["*"]	\N	2023-10-10 08:20:44	2023-10-10 08:20:44
151	App\\Models\\User	74	74Binsha Mbbinshambrs@gmail.com	2da83289898786c878e43c9a7a77ffa80329dbc9b0639c2e25bc5671d1e77f04	["*"]	\N	2023-10-10 08:38:35	2023-10-10 08:38:35
152	App\\Models\\User	74	74Binsha Mbbinshambrs@gmail.com	2c3f47aff4ddb837d6b68b8315bf1ce00b721b7071ca5f2c437ad0d6d53c64ea	["*"]	\N	2023-10-10 09:10:58	2023-10-10 09:10:58
153	App\\Models\\User	83	Personal Access Token	4205d9f92ab107268a0ffa9357d9b184af979938b1ef6cb47c3c61a6d80fcb4b	["*"]	\N	2023-10-10 09:35:10	2023-10-10 09:35:10
154	App\\Models\\User	83	83testtestdriver@gmail.com	5a580bc37564a44bf948ec508acb9e1bad70df376b4c826c02036b48012c2ed6	["*"]	\N	2023-10-10 09:35:34	2023-10-10 09:35:34
155	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	bc5a8296f1360f09f2ea97955bbb9fc053600bcc7f7880fe91d237e5f8cee06b	["*"]	\N	2023-10-10 10:05:09	2023-10-10 10:05:09
156	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	bdfdea2b4cfcba120da407d33bbe53a5cbd338de07fd58f347140ba51e50d9b3	["*"]	\N	2023-10-10 10:05:46	2023-10-10 10:05:46
157	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	c895714a407974c17edba51e8afeb99a5b19c3af381ff359bb593a0be99f23e3	["*"]	\N	2023-10-10 10:29:24	2023-10-10 10:29:24
158	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	d11e5f48bf09f105b78ed2eed97de0670ddaeb20cedc879415b884d00bf1bc0d	["*"]	\N	2023-10-10 10:57:46	2023-10-10 10:57:46
159	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	9b122855b988a9b75f3106019a4de75a4f45346061ca7b809eb65c960da09b6b	["*"]	\N	2023-10-10 14:42:34	2023-10-10 14:42:34
160	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	32db1bf6f5939bc5bdc9970212ee605a2b7becc5db84859435931397833b308f	["*"]	\N	2023-10-10 16:43:13	2023-10-10 16:43:13
161	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	9df85a618d7b7a11c157ac25d83f19c06720857b917501c83a10a285f84d7f31	["*"]	\N	2023-10-10 16:45:22	2023-10-10 16:45:22
162	App\\Models\\User	82	82test fivetest5@gmail.com	e102cdda6cc46f43462c40abe58a7c444224ba2bde8ca666ad467bdb9c91e6d4	["*"]	\N	2023-10-10 17:20:56	2023-10-10 17:20:56
163	App\\Models\\User	83	83testtestdriver@gmail.com	34165a3c4ad8b0f5e7006c223c78863806146066dd6ccc5152691e9b6d0f233f	["*"]	\N	2023-10-10 21:41:24	2023-10-10 21:41:24
164	App\\Models\\User	83	83testtestdriver@gmail.com	55d3fcca68a6ab72188df831d9154322ec644556e3cbae3541c59af30075633d	["*"]	\N	2023-10-10 21:44:09	2023-10-10 21:44:09
165	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	6f3c8a02b37ea472c5024269776e898dd88147b05f4bb7d7658599ee30c5ccba	["*"]	\N	2023-10-10 21:59:20	2023-10-10 21:59:20
166	App\\Models\\User	83	83testtestdriver@gmail.com	39cd86bfd326057d6bf91027f13c57350b811377c26c8a3c1b359f232040cf4c	["*"]	\N	2023-10-11 01:42:54	2023-10-11 01:42:54
167	App\\Models\\User	83	83testtestdriver@gmail.com	68e2e7848dd200ad970a4a654f12290bb6a047f8b280b362a970f5a57c3ce0f5	["*"]	\N	2023-10-11 08:38:14	2023-10-11 08:38:14
168	App\\Models\\User	83	83testtestdriver@gmail.com	0e454c62ebdbad92988f9ffa1eebbbc902e4c4075590b428b11a0c22ba290163	["*"]	\N	2023-10-11 08:43:01	2023-10-11 08:43:01
169	App\\Models\\User	83	83testtestdriver@gmail.com	aa123e20b50e56770a72add0ea0e8f0365448b9316c6f12d0a903027ee275410	["*"]	\N	2023-10-11 09:01:33	2023-10-11 09:01:33
170	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	1d15b0364f374169616293cdd8b9b647b42a666bb2d14dc76efdb9bd27aebf7b	["*"]	\N	2023-10-11 09:03:50	2023-10-11 09:03:50
171	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	59bb355db656e2226c2dba74ae94329c847130807a11fd03d44a5aa358f45694	["*"]	\N	2023-10-16 14:39:35	2023-10-16 14:39:35
172	App\\Models\\User	83	83testtestdriver@gmail.com	095046f38e5b474d4f3130aa99cd08c1b7eb53a8731c4c686d3fec2b5d4cd546	["*"]	\N	2023-10-16 14:45:03	2023-10-16 14:45:03
173	App\\Models\\User	83	83testtestdriver@gmail.com	957c5c5b0fe850e2937a54ceff3c1e3b747632722696b6632a9cc9700ca13fcf	["*"]	\N	2023-10-16 14:53:18	2023-10-16 14:53:18
174	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	da4d8f6757fe31f17438c02e16c2da08b5f05f5f38cb73760a95747f5df001ef	["*"]	\N	2023-10-16 14:55:09	2023-10-16 14:55:09
175	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	7569845f0e7554ba76720d912017b4a6a90fb678ce5c0a6d4f6d424c86ee58e4	["*"]	\N	2023-10-16 14:57:20	2023-10-16 14:57:20
176	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	cfdcd3eedc18390a248139dbb48d290f09b201dfdcf09a2b6e3b3901890b8a6f	["*"]	\N	2023-10-16 14:57:54	2023-10-16 14:57:54
177	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	8d87a150175c588bb3ef7285137b53c49954238062fa6fb4d8fe67c71e4e379f	["*"]	\N	2023-10-16 15:00:14	2023-10-16 15:00:14
178	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	af4a704a1d00037dafcf5ca41d751ddc549a11ccd56c5aac42aeb0d6ff7ad2c0	["*"]	\N	2023-10-16 15:55:59	2023-10-16 15:55:59
179	App\\Models\\User	83	83testtestdriver@gmail.com	574c60e8fcb5039fc04f08e497800ec94a6349b51f31ff42cb58a79688449b60	["*"]	\N	2023-10-16 15:58:41	2023-10-16 15:58:41
180	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	a903e0a5f037b70147bbd34dfe5fa4d8a5de6300e743bfb76ec6c236c8b16158	["*"]	\N	2023-10-16 16:03:16	2023-10-16 16:03:16
181	App\\Models\\User	83	83testtestdriver@gmail.com	334190d092adadc73f0c1acf48881df62b484651a831c89738cf0c40a45eebe9	["*"]	\N	2023-10-16 16:04:56	2023-10-16 16:04:56
182	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	e2932aa523edaa59b2a81bb9b2657ead14a2b48b8eaae78acc6d7cfb1d4775ce	["*"]	\N	2023-10-16 16:14:25	2023-10-16 16:14:25
183	App\\Models\\User	83	83testtestdriver@gmail.com	9d32aca26b3552f86dc5a8c2e56e6735d4e1e425d75ea5b1661174300d8683b7	["*"]	\N	2023-10-16 16:30:16	2023-10-16 16:30:16
184	App\\Models\\User	83	83testtestdriver@gmail.com	b107f62957446cb37b1bf65009fd651be289472db6f0ad75d94357e217fcf78d	["*"]	\N	2023-10-16 16:33:38	2023-10-16 16:33:38
185	App\\Models\\User	83	83testtestdriver@gmail.com	fc169cf932c00b2100f1c1bddb322b1653e4540077d4803df6c88f5208a4f4a7	["*"]	\N	2023-10-16 16:33:56	2023-10-16 16:33:56
186	App\\Models\\User	83	83testtestdriver@gmail.com	cbb52b93c8b54f134e3571d3838f1b94db6d899d616931a794ced89c299e7f78	["*"]	\N	2023-10-16 16:35:51	2023-10-16 16:35:51
187	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	c7d275b39ab672120e738bc78aa63c944dcda813dadf648a2aff380ba29904bf	["*"]	\N	2023-10-16 16:38:26	2023-10-16 16:38:26
188	App\\Models\\User	83	83testtestdriver@gmail.com	2e70027530693ba06928bd75e7c19e6b58b04b26467962f72323c7c96b220145	["*"]	\N	2023-10-16 16:42:38	2023-10-16 16:42:38
189	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	06d524b849c03103a3b99ffd09d0880644fd464a5f4b649ac92a61bec5105112	["*"]	\N	2023-10-16 17:07:17	2023-10-16 17:07:17
190	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	6e313b34468cc24ef22f53109e184dfaf6db1166d99309d46f968629772749de	["*"]	\N	2023-10-16 17:16:44	2023-10-16 17:16:44
191	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	f1f44dd8e039a22a99bacee166de0813d8ce9c72bcbc0489588d20300c8930ad	["*"]	\N	2023-10-17 08:26:25	2023-10-17 08:26:25
192	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	3ed5bf74b683765fb709ca259d440d42a24b589307adb07fd7db397e50f6e17d	["*"]	\N	2023-10-17 08:57:47	2023-10-17 08:57:47
193	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	1c02ec71b375f774af26e1dcd0fcbd21e81a3b3f2f4167dbf9e67079de2caeac	["*"]	\N	2023-10-17 09:05:16	2023-10-17 09:05:16
194	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	decf6251d1256a0c248037141d4a6543c484842bb9582f2d2715609b8c9d7a1f	["*"]	\N	2023-10-17 09:19:53	2023-10-17 09:19:53
195	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	351244302f98701a7a87ee91000b2d0b3f04a704252c2b9722fc0f706984b41a	["*"]	\N	2023-10-17 09:51:40	2023-10-17 09:51:40
196	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	5e77024b92b07909260a03ff4c69389eca21219a81d4eb77e1a2285b31d62658	["*"]	\N	2023-10-17 09:55:09	2023-10-17 09:55:09
197	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	e40fb880245c0ff087b6f6c73ece0b61cd1d3784fccade5b2842f812c68b15ef	["*"]	\N	2023-10-17 09:55:59	2023-10-17 09:55:59
198	App\\Models\\User	83	83Binshatestdriver@gmail.com	85161e4612969fd261822edf4a1dc7a1e352f718f649439e2b0738deba98fd60	["*"]	\N	2023-10-17 09:57:36	2023-10-17 09:57:36
199	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	b77753ba65924770a999a8b0888ab799527d904f61d249113a8928db74f551b3	["*"]	\N	2023-10-17 10:06:04	2023-10-17 10:06:04
200	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	cd42a001efecdcfc3df720d39dbab1af5ac7c4b8bc8d51cf4131774e0bee0acf	["*"]	\N	2023-10-17 10:07:08	2023-10-17 10:07:08
201	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	057fc2c5a2115da2501ecc66297cbced007c0dd1691f2848741616a6df345849	["*"]	\N	2023-10-17 10:08:34	2023-10-17 10:08:34
202	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	33fdd447d1bc7dd7269831a58e85b539c4303b930aeed1c765bed1a7474c97b5	["*"]	\N	2023-10-17 10:09:21	2023-10-17 10:09:21
203	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	d9f3145c5fc39d66f5f279dbf5703d15aa26b92b91d067c21ff3ac0d647ee447	["*"]	\N	2023-10-17 11:34:05	2023-10-17 11:34:05
204	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	3748fa121cfe463ee2213a357e426e62bb5682de65e69c6a9690609d3e6956f0	["*"]	\N	2023-10-17 11:45:50	2023-10-17 11:45:50
205	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	91bec6e7180aa4f5049620fa422e14d28ba8a69d333d844895aa849c5a87c235	["*"]	\N	2023-10-17 11:58:57	2023-10-17 11:58:57
206	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	65b88217f5a8456b95ae636617f1abf8356430c30b3a4ba52c5765aeef2240db	["*"]	\N	2023-10-17 12:03:17	2023-10-17 12:03:17
207	App\\Models\\User	71	71android testerandroid_driver12@hotmail.com	542c076be1e3eb54fb51f0113214599f48a1d31f086d4797f1ec10bd35612440	["*"]	\N	2023-10-17 12:44:16	2023-10-17 12:44:16
208	App\\Models\\User	83	83Binshatestdriver@gmail.com	77ba8b65f27c95cc97c919024249dbdc7c8bfb885b8780c35a6abfc24844ebb9	["*"]	\N	2023-10-17 12:45:12	2023-10-17 12:45:12
209	App\\Models\\User	83	83Binshatestdriver@gmail.com	9c6469d49e3feb3a30d5919811fa8dd275a16811a48f40bccd9bfd0dbbb76c3d	["*"]	\N	2023-10-17 12:46:03	2023-10-17 12:46:03
210	App\\Models\\User	71	71android testerandroid_driver12@hotmail.com	5abd4dad7c65a735a0eabec031bdbf002d35becd650ec72082976d8f60bef65f	["*"]	\N	2023-10-17 12:47:33	2023-10-17 12:47:33
211	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	01531b60c5ba5295a21d48c49c4bd6b01b561a90b78f7dba8564511019e66a74	["*"]	\N	2023-10-17 13:18:23	2023-10-17 13:18:23
212	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	9a30c7bf00769421adfa39ec94c27066dc09b99d47780b6b7a543fb6f1e0d146	["*"]	\N	2023-10-17 15:01:46	2023-10-17 15:01:46
213	App\\Models\\User	71	71android testerandroid_driver12@hotmail.com	0723163ab9c3964d637d9f7f3a9ccba31cbd3be2cca5df646ff48054fe22ced8	["*"]	\N	2023-10-17 15:11:43	2023-10-17 15:11:43
214	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	c1a38d99d44fbb2da47a3f4d9d2775793b39a9d12c65c3e4275d86bb9dfd033b	["*"]	\N	2023-10-17 15:16:20	2023-10-17 15:16:20
215	App\\Models\\User	83	83Binshatestdriver@gmail.com	a27f578e9642cfe23a3b34e19f31edf73c1da9755d98c2875061d39cdcf6eb86	["*"]	\N	2023-10-17 15:18:10	2023-10-17 15:18:10
216	App\\Models\\User	83	83Binshatestdriver@gmail.com	57ed29687460b074647044532e976a0ff0d18a65a2924738e7ffa25c9b736b0b	["*"]	\N	2023-10-17 15:19:16	2023-10-17 15:19:16
217	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	1d19f32fd529470706b9faa7907172bb4e6a55572b4cbd055a30dc321e0bc7d2	["*"]	\N	2023-10-17 15:27:43	2023-10-17 15:27:43
218	App\\Models\\User	83	83Binshatestdriver@gmail.com	14bb77f30f17557fcda42963fa0793e304a68e3b78dfd31ce87124837308b68c	["*"]	\N	2023-10-17 15:36:17	2023-10-17 15:36:17
219	App\\Models\\User	83	83Binshatestdriver@gmail.com	d65b4e60625761532ee3bd48e63cf3a9268a0773a2fdb9d2ef8af52e8bf5cdb5	["*"]	\N	2023-10-17 15:37:02	2023-10-17 15:37:02
220	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	10cd8ad948bfaa5a078d86ad5ff006e8b45aa35de7908d129762af7fbd530a0e	["*"]	\N	2023-10-17 15:51:23	2023-10-17 15:51:23
221	App\\Models\\User	83	83Binshatestdriver@gmail.com	35ba7e7c951c5b383aff21d03eb2ba40a25d4cc9c050611ede44864204046957	["*"]	\N	2023-10-17 19:50:14	2023-10-17 19:50:14
222	App\\Models\\User	83	83Binshatestdriver@gmail.com	c8736a859aad7e5e35589cbfe646b70d357df36ee0eff62579914822dc9b103d	["*"]	\N	2023-10-18 02:58:48	2023-10-18 02:58:48
223	App\\Models\\User	83	83Binshatestdriver@gmail.com	4896fea3d094551b8f524d3ab8b2d8cdc192fd2fb13208168043dd40df1fd0be	["*"]	\N	2023-10-18 08:42:12	2023-10-18 08:42:12
224	App\\Models\\User	83	83Binshatestdriver@gmail.com	45960429928aa81f801a1c3565eedeac2bee0855fb5381d64c261bc4e2381943	["*"]	\N	2023-10-18 08:53:27	2023-10-18 08:53:27
225	App\\Models\\User	83	83Binshatestdriver@gmail.com	c116de138f04d1f641144f9705e0d798708a78f9515f3dbdab17077bae2197b3	["*"]	\N	2023-10-18 08:56:30	2023-10-18 08:56:30
226	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	503f996899f0b17fce23bf0f7f384e50f1e951723870f241e5037003fb4a8ea1	["*"]	\N	2023-10-18 10:02:39	2023-10-18 10:02:39
227	App\\Models\\User	83	83Binshatestdriver@gmail.com	e4216c31efb061d6da9acc6a76aff783a6ca29a6117037e30a308a1a5ce1c8cf	["*"]	\N	2023-10-18 10:59:09	2023-10-18 10:59:09
228	App\\Models\\User	83	83Binshatestdriver@gmail.com	d5b0abd83b38333d2077133a35ca0e2911ae268d5f05db47283bc84ca5347c8e	["*"]	\N	2023-10-18 12:05:51	2023-10-18 12:05:51
229	App\\Models\\User	84	Personal Access Token	0c4146b36587aacf81ae55b4abbd086fcbb8d80dd6a85f1f74948520c9521186	["*"]	\N	2023-10-18 12:30:58	2023-10-18 12:30:58
230	App\\Models\\User	84	84D X Technologiesdxbapps@yopmail.com	46e449aaaaeb1779841c1f89a6b8b1f70ad919af22d73eba1133f4853ad684f7	["*"]	\N	2023-10-18 12:30:58	2023-10-18 12:30:58
231	App\\Models\\User	84	84D X Technologiesdxbapps@yopmail.com	3d3e7ede225269c774ec120c0ea7abc4242f904c37577c5003837b938e941197	["*"]	\N	2023-10-18 12:30:58	2023-10-18 12:30:58
232	App\\Models\\User	84	84D X Technologiesdxbapps@yopmail.com	492283b278ba6f9654bc1da1de21ab97592cc788b951ca45caacd93c50453a15	["*"]	\N	2023-10-18 12:44:24	2023-10-18 12:44:24
233	App\\Models\\User	84	84D X Technologiesdxbapps@yopmail.com	6bc2d7a763065170202d65e4e21bf702ff314db973f4dd6adf92a7ebc87c17d8	["*"]	\N	2023-10-18 12:45:36	2023-10-18 12:45:36
234	App\\Models\\User	85	Personal Access Token	da995395322799f221d4ebcccfb8a931af42f66e42966703dcbab590c7e84011	["*"]	\N	2023-10-18 13:16:37	2023-10-18 13:16:37
235	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	cf9654c46c1e02f77c197d2a3d03700c86a479156990cffee0aa7ded3c6a32f2	["*"]	\N	2023-10-18 13:16:37	2023-10-18 13:16:37
236	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	84420597fa409e91fa7b9699cd336ad759f1644fe8e6f2556ea1d69fc0cb3353	["*"]	\N	2023-10-18 13:16:37	2023-10-18 13:16:37
237	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	b37ebd3f4a75538e8816d1da412989fa23aa9e0d558541940315d6fc17ce30e1	["*"]	\N	2023-10-18 15:43:49	2023-10-18 15:43:49
238	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	d50a747e9118c00b8040fffd6ead0512f06b1fabc17aab434591757716ac45a0	["*"]	\N	2023-10-18 16:18:14	2023-10-18 16:18:14
239	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	cfa93c4185501c524ecea49c6e1453dbbc62be3f2a95e86a6b21b27b50500260	["*"]	\N	2023-10-18 16:43:07	2023-10-18 16:43:07
240	App\\Models\\User	83	83Binsha1testdriver@gmail.com	f000b3f558d8fb4e79a394a12c40fdb764c99ca82d763c3465510b8ec08b524b	["*"]	\N	2023-10-18 16:48:38	2023-10-18 16:48:38
241	App\\Models\\User	83	83Binsha1testdriver@gmail.com	088e431bd1a23a1c69f4f163a2a0abe9ce0b2d624b3ef9330a06de835ded2276	["*"]	\N	2023-10-18 16:51:34	2023-10-18 16:51:34
242	App\\Models\\User	73	73Hunain Devhunain88@gmail.com	355f27d56a83e7ce64b11c5d214612016f144609b39ca6c37d1adcfdd20d896a	["*"]	\N	2023-10-18 17:03:51	2023-10-18 17:03:51
243	App\\Models\\User	86	Personal Access Token	919f47e3200bd5e37bd6c2cae3a7a804522ff6dbba274510ad419bdfc43d1f3a	["*"]	\N	2023-10-18 17:25:23	2023-10-18 17:25:23
244	App\\Models\\User	86	86kirankiran@yopmail.com	f6e645b3ec69bbb29ac82c842787ea14d3f0902cd3f18ec25cf875f6d7155703	["*"]	\N	2023-10-18 17:25:51	2023-10-18 17:25:51
245	App\\Models\\User	83	83Binsha1testdriver@gmail.com	b33dd43104366f08db043682d608a3f5e90ac922b6418b23b5e17b815672ec7b	["*"]	\N	2023-10-18 21:33:30	2023-10-18 21:33:30
246	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	e8185ed1ae6a2577d44bf8ff73b1e5471955f08717470e15e1486feb3edd6863	["*"]	\N	2023-10-18 22:23:17	2023-10-18 22:23:17
247	App\\Models\\User	83	83Binsha1testdriver@gmail.com	a7e5f841d51fd5dd6f5155a274c67fdb21cf525be4533c4041843384505aae34	["*"]	\N	2023-10-19 03:17:39	2023-10-19 03:17:39
248	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	c3fcaf6dbba31b2d1c8dc6a8b2d21ff4eaf1254f167f7f522a4caeff0f28cd51	["*"]	\N	2023-10-19 05:59:26	2023-10-19 05:59:26
249	App\\Models\\User	83	83Binsha1testdriver@gmail.com	22a5b2cf2507e22119a269d467b6878d447041107472b8f21b46b8d44f7f5dd5	["*"]	\N	2023-10-19 06:00:02	2023-10-19 06:00:02
250	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	182b11878f2622035c1f416ab49ceafb1ce098ea19ef29334d2bc973993e1275	["*"]	\N	2023-10-19 11:05:50	2023-10-19 11:05:50
251	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	02df4f634ae88d9aeafab8de34d3de24efa11972eb8709768dbd926dadc7f952	["*"]	\N	2023-10-19 11:48:04	2023-10-19 11:48:04
252	App\\Models\\User	86	86kirankiran@yopmail.com	75c1d18f9270f64a9c61cd5811ca213ec32855d1e08f0f0fe479c3b0270d1fcf	["*"]	\N	2023-10-19 11:49:17	2023-10-19 11:49:17
253	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	7b8117efa881bb4acbc7122646de483c3c0239ba90667b2031216344ca702bc8	["*"]	\N	2023-10-19 11:52:35	2023-10-19 11:52:35
254	App\\Models\\User	86	86kirankiran@yopmail.com	66ac91689ab632da4aab3dc107c33d969bcbefaaa5f8e6362199e1150b79fd8a	["*"]	\N	2023-10-19 11:57:04	2023-10-19 11:57:04
255	App\\Models\\User	86	86kirankiran@yopmail.com	f85fa2372e54ae9cafaf048ca883de123946c628ef0c66237ec62fee34e7e949	["*"]	\N	2023-10-19 11:58:52	2023-10-19 11:58:52
256	App\\Models\\User	86	86kirankiran@yopmail.com	acf6b7fdfebad2ba0cece10e51afc10964b93ad4491dc779614597348874d3a5	["*"]	\N	2023-10-19 12:28:53	2023-10-19 12:28:53
257	App\\Models\\User	87	Personal Access Token	89fcbfd27e4496a6aca662622cbbf60472862ff0d3f70c5ff05c73f4352c28f4	["*"]	\N	2023-10-19 12:30:06	2023-10-19 12:30:06
258	App\\Models\\User	87	87test Driver Twotestdriver2@gmail.com	87c9265102ee91444aa619403da6f8036d957154170fae3db5aeed3e07a95c24	["*"]	\N	2023-10-19 12:30:24	2023-10-19 12:30:24
259	App\\Models\\User	88	Personal Access Token	677e4be76181214679618e412d461293f98c61e26eae8245223e9682e4087f24	["*"]	\N	2023-10-19 12:35:14	2023-10-19 12:35:14
260	App\\Models\\User	88	88Kishorekishore@yopmail.com	36f92afd74dbd8ed577248663694b11440de245991b3c5069d4e7fe82eed5fdf	["*"]	\N	2023-10-19 12:35:36	2023-10-19 12:35:36
261	App\\Models\\User	83	83Binsha1testdriver@gmail.com	a2c22e6479fa5a73433681c010c8e23d44ffbddc9ddc5b6fdf6653b90700534b	["*"]	\N	2023-10-19 13:03:31	2023-10-19 13:03:31
262	App\\Models\\User	83	83Binsha1testdriver@gmail.com	2e09655bf8e503c52e0dfae52fe7f37dd00a7f1fbad5e89da4f1d9f576b794ad	["*"]	\N	2023-10-19 19:47:35	2023-10-19 19:47:35
263	App\\Models\\User	89	Personal Access Token	fd6f99640b57eedfe0017145520d9340e2bfd8b77ed52b2a21347b2e53966546	["*"]	\N	2023-10-19 21:47:35	2023-10-19 21:47:35
264	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	6a2d4a8fcc4a89266ffd2ab2984afa85db7978e5f1a0e8faa0c89502a1b63dd7	["*"]	\N	2023-10-19 21:51:36	2023-10-19 21:51:36
265	App\\Models\\User	83	83Binsha1testdriver@gmail.com	befd93063696c7d270ab0ae2094e07e91360ebc8784b38b81cc67fd8112baf84	["*"]	\N	2023-10-19 22:01:13	2023-10-19 22:01:13
266	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	f20c0bf5eac90283f09efcdae38382122bed673815fc3e20e84e26ee31ff2c39	["*"]	\N	2023-10-19 22:29:19	2023-10-19 22:29:19
267	App\\Models\\User	83	83Binsha1testdriver@gmail.com	c42961593a09c222afc3cd445df71dfb02810f2bc65c5e7549b75eb82bcc10b5	["*"]	\N	2023-10-19 22:55:02	2023-10-19 22:55:02
268	App\\Models\\User	83	83Binsha1testdriver@gmail.com	11d42fac1c2b3cc5fe4f3eccfeb40926d665c02bf8ab16e205ec5d3c4adaf8c7	["*"]	\N	2023-10-19 23:08:58	2023-10-19 23:08:58
269	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	d05dcf26798f3c1fdadf4e1fefce6318b0367c594d20b860555eac6259c14ada	["*"]	\N	2023-10-19 23:14:17	2023-10-19 23:14:17
270	App\\Models\\User	83	83Binsha1testdriver@gmail.com	dc1aa817ba0344240b5d195519484f73f813b6c845b72bd2fc411dcbe36ef11a	["*"]	\N	2023-10-19 23:19:53	2023-10-19 23:19:53
271	App\\Models\\User	83	83Binsha1testdriver@gmail.com	367d917279322c8feffa0bd8c38135798691cdc1ae5bc55bc870d1559235dc73	["*"]	\N	2023-10-20 09:17:57	2023-10-20 09:17:57
272	App\\Models\\User	90	Personal Access Token	f71bb76c5842494f977f2ecbd7f355ba4ecf9807cf8039706aa950df8b9dfadb	["*"]	\N	2023-10-20 10:10:06	2023-10-20 10:10:06
273	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	6bf669de217c584f00bdfccc435cfada5d0ba0d3d23ff5336e87a41118a31126	["*"]	\N	2023-10-20 10:12:06	2023-10-20 10:12:06
274	App\\Models\\User	91	Personal Access Token	f6e86399307814699c783d2eb1464e176056e211e2c98e3dc679cd45f5b7f352	["*"]	\N	2023-10-20 10:17:29	2023-10-20 10:17:29
275	App\\Models\\User	91	91test fourtestdriver4@gmail.com	bf99e101f9f2eef71a9c16fb852b9a5502053bac0d0e628feb4df893508d1d88	["*"]	\N	2023-10-20 10:18:48	2023-10-20 10:18:48
276	App\\Models\\User	92	Personal Access Token	4e4cdcbf96e3c3a20d0b5fb9be12ceb0b18a61e49c83ac55a36e9aa5ceb94a2d	["*"]	\N	2023-10-20 10:30:35	2023-10-20 10:30:35
277	App\\Models\\User	92	92Abdul Ghanidriver@driver.com	efd2ee88bf55455d6107bf7ac9d67053955f431d53202c5aa3fb2247c34bd983	["*"]	\N	2023-10-20 10:30:35	2023-10-20 10:30:35
278	App\\Models\\User	93	Personal Access Token	a53fc870fb80dffed9c1c45030d9f68ac3370568d15619d116fcb6a5dcca50f2	["*"]	\N	2023-10-20 10:33:24	2023-10-20 10:33:24
279	App\\Models\\User	93	93Meenumeenu@gmail.com	f553f72acf05c4389a211712071a729c4c9e850d7b926e87db898dfd61c8d0fd	["*"]	\N	2023-10-20 10:33:24	2023-10-20 10:33:24
280	App\\Models\\User	93	93Meenumeenu@gmail.com	5c8f40b88fe43d596458242a9c4ae1d527478d325abc4e93bae3603ae3e39c40	["*"]	\N	2023-10-20 10:33:24	2023-10-20 10:33:24
281	App\\Models\\User	94	Personal Access Token	4397cddbdb1a23c036a6ade43251a342664bea03548b0bed4ee9edebb7b620b4	["*"]	\N	2023-10-20 10:39:19	2023-10-20 10:39:19
282	App\\Models\\User	94	94yest fivetestdriver5@gmail.com	14927edf6497d3a2cdb4ecb663c4c6d47f4e64821293fcc5c11817fc281b3c36	["*"]	\N	2023-10-20 10:39:19	2023-10-20 10:39:19
283	App\\Models\\User	95	Personal Access Token	799c24d8be72b5693a28fea79b1c12a997235f8d940ab95121f786521ffb26e8	["*"]	\N	2023-10-20 10:44:22	2023-10-20 10:44:22
284	App\\Models\\User	95	95test sixtestdriver6@gmail.com	620d1d67dee3615aa67e51bb2458aec4af2bc733c8e8f1d251e15e6e5d1af5ec	["*"]	\N	2023-10-20 10:44:22	2023-10-20 10:44:22
285	App\\Models\\User	96	Personal Access Token	7879127cfdef8d835bbf196a9982e2e7e465bfa8ca673e07e673a91863687fe5	["*"]	\N	2023-10-20 10:48:45	2023-10-20 10:48:45
286	App\\Models\\User	96	96test seventestdriver7@gmail.com	61eea1d331bddbdd3738b96d5e3659d30b7332c6a62feb538f3dbd9038070195	["*"]	\N	2023-10-20 10:48:45	2023-10-20 10:48:45
287	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	fce9fcd51fc19c1405814042b8b53634f2473ee589d9697820a2872dd988e0db	["*"]	\N	2023-10-20 10:53:32	2023-10-20 10:53:32
288	App\\Models\\User	83	83Binsha1testdriver@gmail.com	980681603077ba002006070e0a597f8d9c380a70623f992b99baa62421e13975	["*"]	\N	2023-10-20 13:10:58	2023-10-20 13:10:58
289	App\\Models\\User	97	Personal Access Token	72c685d422db2aa1c59c6ab8f66bda125b7c8a1bae139d07523652b1cd9be93a	["*"]	\N	2023-10-20 13:51:51	2023-10-20 13:51:51
290	App\\Models\\User	97	97Driver Onedriver1@yopmail.com	9fe01fa87b55307d396ebcf64811e2f68b4203e5b093e88443e195e9fd6e484c	["*"]	\N	2023-10-20 13:51:51	2023-10-20 13:51:51
291	App\\Models\\User	98	Personal Access Token	1d7d38b03acfbf2d4033038a9376895585c9a3e962d21e39cb2bb9fdf482844d	["*"]	\N	2023-10-20 13:55:57	2023-10-20 13:55:57
292	App\\Models\\User	98	98Driver Twodriver2@yopmail.com	424194a8331b95dd119bc29b5acb2a0e1ffd4a7cade532234109ebef6cbd1d86	["*"]	\N	2023-10-20 13:55:57	2023-10-20 13:55:57
293	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	9ae6b68526b2a47957c0fe6ddf0ee5a4a0709cfb78f7c9b827f4ea77fc3781c4	["*"]	\N	2023-10-20 15:25:09	2023-10-20 15:25:09
294	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	9fb55fa6893ec9937577a2c9282f21ab709b0c39fdd0f72187e8281b11a49904	["*"]	\N	2023-10-20 15:27:04	2023-10-20 15:27:04
295	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	29ce4234221c2c9d3d805d4adc091a27378c7dd2bc4dbcc28b80db31693711da	["*"]	\N	2023-10-20 15:29:23	2023-10-20 15:29:23
296	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	a23d920da9eba176860456bfc5a0f286ed90f2b768ea6735aae8d98fee32984f	["*"]	\N	2023-10-20 15:31:47	2023-10-20 15:31:47
297	App\\Models\\User	88	88Kishorekishore@yopmail.com	22314fc46811cc400f86c1b822db1179839ec1f5cab706caeb619e204e6b9b34	["*"]	\N	2023-10-20 15:37:29	2023-10-20 15:37:29
298	App\\Models\\User	99	Personal Access Token	1c7945a5bea4ea88eab28a91cd4624ee0a43f4724d9dfe545b41ed3d0e73de75	["*"]	\N	2023-10-20 15:58:23	2023-10-20 15:58:23
299	App\\Models\\User	99	99B testbdriver@driver.com	6ac541d76ea61cd35a04d80a39e539636fdadd0b170c8c5c99c1d09bcaa95e0a	["*"]	\N	2023-10-20 15:58:23	2023-10-20 15:58:23
300	App\\Models\\User	100	Personal Access Token	ecd95602470a9dcfa9ced594d3920137171bd4a144abcc263c555e3017c41849	["*"]	\N	2023-10-20 16:07:04	2023-10-20 16:07:04
301	App\\Models\\User	100	100B testjohn@driver.com	2209c5f3a80f593a694229ac3a82a92db9c48f7d74bf4cdf76d18fd6f5398308	["*"]	\N	2023-10-20 16:07:04	2023-10-20 16:07:04
302	App\\Models\\User	101	Personal Access Token	bec78ea5f2c9eb71fa4aa05b2ae57308b7e54c1c7efc173dc43560bdb4742601	["*"]	\N	2023-10-20 16:48:02	2023-10-20 16:48:02
303	App\\Models\\User	101	101B testlivedriver@driver.com	9dc6c757d2021089358ea5af265ea3ec92ea8996c484f9c96d008e076f6a2f7d	["*"]	\N	2023-10-20 16:48:02	2023-10-20 16:48:02
304	App\\Models\\User	102	Personal Access Token	918df4ea2133b3f6223e500650669843ec875dc7fb6e623f83575aa4ebe5fd16	["*"]	\N	2023-10-20 16:50:37	2023-10-20 16:50:37
305	App\\Models\\User	102	102B testkiyara@driver.com	b76a24a5649ef736de9acc9df2b4383efc48a85667836562e0b3ee88ecb5cab9	["*"]	\N	2023-10-20 16:50:37	2023-10-20 16:50:37
306	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	f5de93cb80bde036daf4973c6c6991ce5f5e49e232401f3bbe52379f05bf41e5	["*"]	\N	2023-10-20 19:39:58	2023-10-20 19:39:58
307	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	bf3ec89348fbb37aba0955d4b7774c430e5836ce96e3a24d411df60ca26cda63	["*"]	\N	2023-10-20 19:44:23	2023-10-20 19:44:23
308	App\\Models\\User	83	83Binsha1testdriver@gmail.com	840b82503c584bc14ffeccb77944a8880886779a421aaf6ed2626f2e9aedf8f6	["*"]	\N	2023-10-20 23:12:11	2023-10-20 23:12:11
309	App\\Models\\User	83	83Binsha1testdriver@gmail.com	a2c57d263468e4b1ad21c4e2da25a3142ec7392e0ab096d1dec2cc3a02308bd4	["*"]	\N	2023-10-20 23:30:25	2023-10-20 23:30:25
310	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	013c112cc8f1d3a294f172e5cc5e4e74ed03e1e9d40cb815d2bc01b55def898b	["*"]	\N	2023-10-21 09:12:16	2023-10-21 09:12:16
311	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	42bff89015e0a4562b840ac04910d9e94393dbdb3d92c987a5fdbc8df4e0e146	["*"]	\N	2023-10-21 09:29:33	2023-10-21 09:29:33
312	App\\Models\\User	83	83Binsha1testdriver@gmail.com	0e9a9b206e1e20aeeb4c169f2fdea290e183fda1de323b2b0040caeeafc58d72	["*"]	\N	2023-10-21 09:33:46	2023-10-21 09:33:46
313	App\\Models\\User	103	Personal Access Token	3f587d86d8c2ef9ed9a852469b5c57eeadf1c81b8afaed488f515c65a979374b	["*"]	\N	2023-10-21 10:39:24	2023-10-21 10:39:24
314	App\\Models\\User	103	103hunain dev ninehunain99@gmail.com	7ead06a50bb3933a8aa60bde0aeb045dfd10426f743a9fa4ca8cda54fd876177	["*"]	\N	2023-10-21 10:39:25	2023-10-21 10:39:25
315	App\\Models\\User	103	103hunain dev ninehunain99@gmail.com	e5a69faa9f70d9ce4436d2152dcdfacb7f467a884732c1a7e74dfcde80e064c1	["*"]	\N	2023-10-21 10:39:25	2023-10-21 10:39:25
316	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	82e8f6ebe34fefd92935c32ec5337888c65d0034d0e73d2fe8ecce18c9af5ecd	["*"]	\N	2023-10-24 08:43:37	2023-10-24 08:43:37
317	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	9442a0bfe8722bc83e8e29857bc63dedeb61b6b047af02bc0014e789e91ac7fe	["*"]	\N	2023-10-24 10:41:35	2023-10-24 10:41:35
318	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	cca41d1d381e41f3b3f7a35a72d82174191c2d66a12cb6ef5bf879ba78274a01	["*"]	\N	2023-10-24 11:19:07	2023-10-24 11:19:07
319	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	9d477178a56f05b81f72ca2072b329dc22c036e06cdefa6caf1c95fedad842ef	["*"]	\N	2023-10-24 11:20:20	2023-10-24 11:20:20
320	App\\Models\\User	90	90Abdul Ghanidriver@gmail.com	55aab48bf87ef3f0e22a48a8ab47a4cd2be34038bd6030d6a23ffb8423390d27	["*"]	\N	2023-10-24 11:23:25	2023-10-24 11:23:25
321	App\\Models\\User	90	90Abdul Ghanidriver@gmail.com	476d477c6ef0ddffec74c13e81ec249b462df60bad98259817c655b4336e2698	["*"]	\N	2023-10-24 11:27:58	2023-10-24 11:27:58
322	App\\Models\\User	104	Personal Access Token	796137e638548b0b144738e7c67614bbcff60586b176624c8855f75e16fcfc94	["*"]	\N	2023-10-24 11:28:58	2023-10-24 11:28:58
323	App\\Models\\User	104	104Danish Nisardaani4900@gmail.com	eb96634f5703e343fde7a51b5eea94e10cb3a8094ef030071d1c1888868a640a	["*"]	\N	2023-10-24 11:28:58	2023-10-24 11:28:58
324	App\\Models\\User	90	90Abdul Ghanidriver@gmail.com	0d1eb3799f55ee42be2054e6bd52d7ee21c4ca5a46032df46bbd5067853c523c	["*"]	\N	2023-10-24 11:31:13	2023-10-24 11:31:13
325	App\\Models\\User	105	Personal Access Token	ca21a298aeda5fcaa8ac3055d6451030e267178dd5a594972cbfc3d946c56ae0	["*"]	\N	2023-10-24 11:34:09	2023-10-24 11:34:09
326	App\\Models\\User	105	105Dublindublin@gmail.com	a47e024dbefd9d9a6f08e23a0ab662974c66679ba229b3c02c5586294aa21f81	["*"]	\N	2023-10-24 11:34:10	2023-10-24 11:34:10
327	App\\Models\\User	105	105Dublindublin@gmail.com	c6f6c6b6280cd1854087be9d67135e4b353f90734901e3a903d12e2be96c534f	["*"]	\N	2023-10-24 11:34:10	2023-10-24 11:34:10
328	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	7a820baf4c6b982faf35547b3e3c75d57470ad15133abc2b94b57c32aaf65140	["*"]	\N	2023-10-24 11:34:22	2023-10-24 11:34:22
329	App\\Models\\User	97	97Driver Onedriver1@yopmail.com	d3c550ed36a5e01c1d6f01a42238c2ce5427c090637f54673fb4602fa511d2e6	["*"]	\N	2023-10-24 11:38:28	2023-10-24 11:38:28
330	App\\Models\\User	105	105Dublindublin@gmail.com	8581e89b1fe730a6b560cde62c4d8d74427150f9e046c8d0f512a75fe33cd9ab	["*"]	\N	2023-10-24 11:44:21	2023-10-24 11:44:21
331	App\\Models\\User	83	83Binsha1testdriver@gmail.com	2b21a7dad400b6943659c7ec29c68a523d0e8821c2e5b38e5eebc42fb103cbf1	["*"]	\N	2023-10-24 11:45:33	2023-10-24 11:45:33
332	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	4b2d36f55b77196e60341fa42ee1f7ebda18e1dda08707cb86f426c2eb996d59	["*"]	\N	2023-10-24 11:48:18	2023-10-24 11:48:18
333	App\\Models\\User	83	83Binsha1testdriver@gmail.com	2bd131c29ea3a132b5a4c1b93f211df8d99e250284cfd283edf13c47dc955a62	["*"]	\N	2023-10-24 12:04:26	2023-10-24 12:04:26
334	App\\Models\\User	90	90Abdul Ghanidriver@gmail.com	d71c24f958442fc43e178cbd4adce80e20e76dff4d643b7c1cd5fe339add0330	["*"]	\N	2023-10-24 12:17:25	2023-10-24 12:17:25
335	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	d38f29caef0969ac4acfec59a98038b59d5844425514509b6dc6036ec35cb03c	["*"]	\N	2023-10-24 12:28:37	2023-10-24 12:28:37
336	App\\Models\\User	90	90Abdul Ghanidriver@gmail.com	823b5767f59fdcef94dbe5c535df1d8d6f2b1a43874e278a4e6b317c148d7d84	["*"]	\N	2023-10-24 12:32:29	2023-10-24 12:32:29
337	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	171f898ac1d47099da4da00dc68f7a4040f9a681cbdb63a047103af04b7b32ef	["*"]	\N	2023-10-24 14:30:38	2023-10-24 14:30:38
338	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	1c63ac5883415d997fb9fe269da7f0298dde6a327ac5a83c55ac5f1fc3ae6b3a	["*"]	\N	2023-10-24 14:46:37	2023-10-24 14:46:37
339	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	30a688bd740b2ef4bb149b81acfa337e129718eca0b8d34abc3024fa26998472	["*"]	\N	2023-10-24 15:16:12	2023-10-24 15:16:12
340	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	9e3ff33519ef27086811b1de583ba135267c80657d60c2f334caf2890ea79095	["*"]	\N	2023-10-24 15:16:42	2023-10-24 15:16:42
341	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	34b1d3c34c90896f0fb759ea883c6b8439cf46ec03791e020be821c402dea8c6	["*"]	\N	2023-10-24 15:26:40	2023-10-24 15:26:40
342	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	8b3b97d2525c6cb3be870ec4982535ede5b7bfcecb5ecbfe3da61d510c9166aa	["*"]	\N	2023-10-24 15:45:21	2023-10-24 15:45:21
343	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	e851acdace625ee4e05f0b8ab97e48b94d394b88b59c23412535866b5627f75e	["*"]	\N	2023-10-25 09:13:13	2023-10-25 09:13:13
344	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	a4c5857409800dbb7f17890a9b248d750e99fa705cd422e4153fdae8d40a3a7c	["*"]	\N	2023-10-25 10:14:34	2023-10-25 10:14:34
345	App\\Models\\User	98	98Driver Twodriver2@yopmail.com	5115ef317a7a76c5b34d55fcb55531ba58d555f5e80f3558762d4afc6585133f	["*"]	\N	2023-10-25 10:34:52	2023-10-25 10:34:52
346	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	b84fad9d1be19f6f8065027fab9ac5ee864352bdda972857d61de0965e27c130	["*"]	\N	2023-10-25 14:19:25	2023-10-25 14:19:25
347	App\\Models\\User	108	Personal Access Token	8389f0e67b298d9fccda090f9af5663c6e392ee901ddd7cd167fd0ee0aff7c3d	["*"]	\N	2023-10-25 16:23:27	2023-10-25 16:23:27
348	App\\Models\\User	108	108KSks@yopmail.com	a617a683eca4fd0d09422bafd45b702d6b0d60ba9c976c1347d2a79c4358f91b	["*"]	\N	2023-10-25 16:23:27	2023-10-25 16:23:27
349	App\\Models\\User	108	108KSks@yopmail.com	88845ae7c8dc17be26972a93743aa951b04be2341166684cae6ab700b3808246	["*"]	\N	2023-10-25 16:23:27	2023-10-25 16:23:27
350	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	02e86dff67e2a02c3bff0d7d180dd84308a4a4c61eb763da59c58ec739c40315	["*"]	\N	2023-10-25 16:45:35	2023-10-25 16:45:35
351	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	2c7ab3e4bbdc130784f594b798b117ebdf5dec5b010bbe310b8449996154ca9c	["*"]	\N	2023-10-26 09:14:50	2023-10-26 09:14:50
352	App\\Models\\User	109	Personal Access Token	eb908b6220bb14df35e068e64a989b87df800ac2896bc54651fd4b8228b697e4	["*"]	\N	2023-10-26 09:21:06	2023-10-26 09:21:06
353	App\\Models\\User	109	109RASras@yopmail.com	f2dc40a20ebe4a0d83c98d934be25aae7a8e7d67fd2b085026a46402c3d7e093	["*"]	\N	2023-10-26 09:21:06	2023-10-26 09:21:06
354	App\\Models\\User	109	109RASras@yopmail.com	0dad304dff27c9f4407ed3cb63e8f40f16aabc877c73a175b2a881e2f8174754	["*"]	\N	2023-10-26 09:21:06	2023-10-26 09:21:06
355	App\\Models\\User	109	109RASras@yopmail.com	af32436452b449eb3e81c328ae0a84c04007a3ed75276023ff1a081926a36f9c	["*"]	\N	2023-10-26 09:21:38	2023-10-26 09:21:38
356	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	9505fb9b47f51ffb46335ed8e7b0228ac0b114e85665b0fb3b074513ab977e1c	["*"]	\N	2023-10-26 09:28:29	2023-10-26 09:28:29
357	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	25e4c55a9afb1bce6b9feef436a0e2b4c67970f83c42fb7a121cb747ae73ddec	["*"]	\N	2023-10-26 09:39:28	2023-10-26 09:39:28
358	App\\Models\\User	109	109RASras@yopmail.com	43b98eab940a9a447cc7cb393c137e1be6ab3d909651d493315386cfd8e21e53	["*"]	\N	2023-10-26 09:40:19	2023-10-26 09:40:19
359	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	5849e038b44fb6a14f74a2c8e7fd352b07056a7998500d3480864b7aaebaffcd	["*"]	\N	2023-10-26 09:45:37	2023-10-26 09:45:37
360	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	2deb98e86ddc76944c3b1f678244d8eae85063d8297ac7721b9706a29cd73582	["*"]	\N	2023-10-26 09:46:56	2023-10-26 09:46:56
361	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	e2416a4414c746b19071c3468bb4795314437121cd3748a648ea87d7865beff1	["*"]	\N	2023-10-26 09:50:41	2023-10-26 09:50:41
362	App\\Models\\User	108	108KSks@yopmail.com	c716b7358d082e8a259c07d53b6e5511196cb87967944a21ae369d8a7b77fdad	["*"]	\N	2023-10-26 09:50:59	2023-10-26 09:50:59
363	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	d06c0d5fc454d06dc55399c2ca2aaded3daccbf962fcfe086542cc69c1a5a94e	["*"]	\N	2023-10-26 09:55:29	2023-10-26 09:55:29
364	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	69bc4ffea417e4b6954d324d6daba7630f0f1f8c77375bb6aa846a6fea5d2166	["*"]	\N	2023-10-26 09:57:55	2023-10-26 09:57:55
365	App\\Models\\User	108	108KSks@yopmail.com	f14a47edaa9421435f635f773cee775b8df40b6b6d60fe37dd5c24755ee1c579	["*"]	\N	2023-10-26 10:24:54	2023-10-26 10:24:54
366	App\\Models\\User	86	86kirankiran@yopmail.com	e6ab3d416653ea705631e703b054bbaf813c2ceba5c66a7fafb5ee70e5094f45	["*"]	\N	2023-10-26 10:53:18	2023-10-26 10:53:18
367	App\\Models\\User	109	109RASras@yopmail.com	2ae85e7a747b39afcf3e7433acd71ce6e8c569f6ad885d53f8d175e1243e7106	["*"]	\N	2023-10-26 13:55:02	2023-10-26 13:55:02
368	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	fc9fe1005e3ec0c510a737a424912695eb1c5d3f30a2384b7333a997b13d701b	["*"]	\N	2023-10-26 14:41:53	2023-10-26 14:41:53
369	App\\Models\\User	109	109RASras@yopmail.com	098ba0fb81dbb577e53be007e12f30f18ff15eacff50f93ad79c40b38f60ad74	["*"]	\N	2023-10-26 14:49:57	2023-10-26 14:49:57
370	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	ff297dea153be5851014a23c9635e2e2015ea181eae65c105f38494b39b3378f	["*"]	\N	2023-10-26 14:57:39	2023-10-26 14:57:39
371	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	56fc3b66527aa1aaf62f4a7d46321fa3f63d0289c0cd13225fdf2d7275e9a29b	["*"]	\N	2023-10-26 15:18:47	2023-10-26 15:18:47
372	App\\Models\\User	97	97Driver Onedriver1@yopmail.com	dfdfa2c508a11b44b9841baa6c6174ec9dd2d2d0e8c405d7f09f48b186185378	["*"]	\N	2023-10-26 15:31:39	2023-10-26 15:31:39
373	App\\Models\\User	88	88Kishorekishore@yopmail.com	25639530361a50bebbb4b28967b69adb937fe07d9efe60a2c28f0f0eca9fbc06	["*"]	\N	2023-10-26 15:54:17	2023-10-26 15:54:17
374	App\\Models\\User	107	107Paulpaul@yopmail.com	3716800e52250aa45f4fc5f8f946db39f0340392a07e28b699313d28e1c387e9	["*"]	\N	2023-10-26 15:55:30	2023-10-26 15:55:30
375	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	68265c9be359e2260bb7441d107d4590c3284df299a594112c97dd0f58f8ba60	["*"]	\N	2023-10-26 16:36:44	2023-10-26 16:36:44
376	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	ef5e4a62440bcd7db009b4cf4fc9681cd270558dd2a10df476d9c2949da40b38	["*"]	\N	2023-10-26 16:43:09	2023-10-26 16:43:09
377	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	d9efdcfcb50e27d3f5592fa3e9e85aa6d30bcea3d66fc3ea04a6d05af5bbdee1	["*"]	\N	2023-10-26 16:44:30	2023-10-26 16:44:30
378	App\\Models\\User	88	88Kishorekishore@yopmail.com	a41e382fc796210e12b852c0994ac03f3632de63516a1f658fc068286343e14e	["*"]	\N	2023-10-26 17:55:13	2023-10-26 17:55:13
379	App\\Models\\User	86	86kirankiran@yopmail.com	855186ec4cf464ed8cd48ed265c6f9d01fd1ac973b4dd8b2c1ae29cdcb0c74df	["*"]	\N	2023-10-26 18:08:11	2023-10-26 18:08:11
380	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	1196199ed39ffd3df33bda3503fe98712f59d08022326f770f6755cce09b86c7	["*"]	\N	2023-10-26 19:04:04	2023-10-26 19:04:04
381	App\\Models\\User	83	83Binsha1testdriver@gmail.com	40032eddecd9cb151abb24a7374e69e685adffab52181fa8dd4cf38b46faad40	["*"]	\N	2023-10-26 19:11:03	2023-10-26 19:11:03
382	App\\Models\\User	110	Personal Access Token	c4940167fb2ecf521d06acf06603128a7ff1608ffaf861e70d22b3d5070240f6	["*"]	\N	2023-10-27 09:08:32	2023-10-27 09:08:32
383	App\\Models\\User	110	110GS Companygs@yopmail.com	fe5d8a099953cb0dfb89181feaa8a81bae0af3a5e4a7efccb9dd532e4be44597	["*"]	\N	2023-10-27 09:08:33	2023-10-27 09:08:33
384	App\\Models\\User	110	110GS Companygs@yopmail.com	d6a677b6a9736cd6f17772af65c1d2f03e262991186bcdaa680b42cd675983e6	["*"]	\N	2023-10-27 09:08:33	2023-10-27 09:08:33
385	App\\Models\\User	110	110GS Companygs@yopmail.com	59dc85bf22b2db52a2e275860d7df46afb5c3f7fb2b3354a7e20f65fa87b3d7f	["*"]	\N	2023-10-27 09:16:39	2023-10-27 09:16:39
386	App\\Models\\User	111	Personal Access Token	44364f7066ca3a91b362e73a1939e1d5882ba0fc61b57c56979dfbb1670620d1	["*"]	\N	2023-10-27 09:24:07	2023-10-27 09:24:07
387	App\\Models\\User	111	111Mathewmathew@yopmail.com	f04903b0530ad4a5d98cfc49b08dc4e3c0772dd2567e603c93a3ff7884a64354	["*"]	\N	2023-10-27 09:24:07	2023-10-27 09:24:07
388	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	e20841221c3ae46ce5d5c2b9de709b93da8ce4bd0fb9e2eebec538b8a02a3571	["*"]	\N	2023-10-27 09:27:18	2023-10-27 09:27:18
389	App\\Models\\User	86	86kirankiran@yopmail.com	8cbfed25d6f01a2c12d17af0303460d5c84aeb2a6916a8eb65928765f848a4ae	["*"]	\N	2023-10-27 09:32:43	2023-10-27 09:32:43
390	App\\Models\\User	112	Personal Access Token	0528cbcf6859b488fb360042323d282317a81cc9cac38d4d886a0056dc9758e2	["*"]	\N	2023-10-27 09:35:00	2023-10-27 09:35:00
391	App\\Models\\User	112	112B ZBZ@driver.com	1b20ca60a1033c7037b1085c762f3e12a7c2bce4ab9469cf266eecc3fca50521	["*"]	\N	2023-10-27 09:35:00	2023-10-27 09:35:00
392	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	b94deadf8f1c32f997057b82e0e114dfe832b8e2a4fb0f88f948cd43caea6e70	["*"]	\N	2023-10-27 09:36:16	2023-10-27 09:36:16
393	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	f7a52b6dbcc00a9122abb85f437e3601dc67b2407f5604546c7d3318865a4d4f	["*"]	\N	2023-10-27 09:50:42	2023-10-27 09:50:42
394	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	0c89ad7549d782b7245225394d4d6265c395b6fda576705cb58b89c80831174f	["*"]	\N	2023-10-27 10:08:45	2023-10-27 10:08:45
395	App\\Models\\User	74	74Glen Maxbinshambrs@gmail.com	5da51b9bae55f2189a89ba3e98f23229b718feb08d4d7f03318e720cc1a29d34	["*"]	\N	2023-10-27 10:10:37	2023-10-27 10:10:37
396	App\\Models\\User	85	85Liverpoolliverpool@yopmail.com	bd97aa9e444824ea5660eb8330bdbf6e0316327ff9b4f456a6e3400b2377749a	["*"]	\N	2023-10-27 10:15:03	2023-10-27 10:15:03
397	App\\Models\\User	113	Personal Access Token	859e78689788b560cee7c7a48d05873efc0946292f0481ff7adbe9bba41b1602	["*"]	\N	2023-10-27 11:10:15	2023-10-27 11:10:15
398	App\\Models\\User	113	113TSI Companytsi@yopmail.com	f18298487af0d0c3f00ca138153588d42570b03b17d73623912c4ab87da7ddb0	["*"]	\N	2023-10-27 11:10:16	2023-10-27 11:10:16
399	App\\Models\\User	113	113TSI Companytsi@yopmail.com	d33e8a64a0a4b72fc83fdf51b8e9983270d9e0778420063b362049abf3c50bc7	["*"]	\N	2023-10-27 11:10:16	2023-10-27 11:10:16
400	App\\Models\\User	114	Personal Access Token	b5c8ccb882be51625f8cb65505ca1db529ebd25c700e633c13160b18811e201e	["*"]	\N	2023-10-27 11:20:06	2023-10-27 11:20:06
401	App\\Models\\User	114	114Samsam@yopmail.com	3d173ef5589fb182e52255576602a527e1be265b28ebcd67560fb848bbdde00d	["*"]	\N	2023-10-27 11:20:06	2023-10-27 11:20:06
402	App\\Models\\User	111	111Mathewmathew@yopmail.com	0f1d2ded56e961e8fe3617de5e1e10ce9b76d3db4bcca60da84675a87282ce23	["*"]	\N	2023-10-27 11:39:38	2023-10-27 11:39:38
403	App\\Models\\User	115	115ghani 33ghaniabro33@gmail.com	e7da204b68980ef0d9d32df70dbb9a40772d7cdb717c1a1887eb76fd5378b661	["*"]	\N	2023-10-27 14:35:03	2023-10-27 14:35:03
404	App\\Models\\User	116	116ghani 33ghaniabro34@gmail.com	1ec545bc556e0fe11cf1748c0a08be0e7e3573a517e11a9e4ea42e0cbc090f3e	["*"]	\N	2023-10-27 14:35:58	2023-10-27 14:35:58
405	App\\Models\\User	117	117sfsocial@gmail.com	9a81cebe894370bc56a3df434ed7036b0723e8e37e7e9cfb86d7eba3d8fb24d7	["*"]	\N	2023-10-27 14:42:05	2023-10-27 14:42:05
406	App\\Models\\User	117	117sfsocial@gmail.com	0d1471ac1d29047285860b1897de7ce98b9c692935b6b2364dcaee7b37adf44f	["*"]	\N	2023-10-27 14:42:07	2023-10-27 14:42:07
407	App\\Models\\User	118	118ghani 33ghaniabro35@gmail.com	a4aa0c27d9af6002d00a38c7d26d145955047a5f109be6824660c3eae57c303f	["*"]	\N	2023-10-27 14:42:38	2023-10-27 14:42:38
408	App\\Models\\User	118	118ghani 33ghaniabro35@gmail.com	3a54fdc4540a4a4e6f182a12d11c7308a6b03ce307e27b72394dd393fa807976	["*"]	\N	2023-10-27 14:42:43	2023-10-27 14:42:43
409	App\\Models\\User	118	118ghani 33ghaniabro35@gmail.com	b10f8fc4afcc010b9423c0baafd5293ef9f360da0cb54b2d1d4e89d3963eb8f0	["*"]	\N	2023-10-27 14:42:50	2023-10-27 14:42:50
410	App\\Models\\User	119	Personal Access Token	c4a1c5cdaf814e475f5001a4f3eee2ae00120e7718f0a4972b6db483c931b4ab	["*"]	\N	2023-10-27 14:59:51	2023-10-27 14:59:51
411	App\\Models\\User	119	119user Oneuserone@gmail.com	ffbec7246e2a42ad12cda728fe85bcb489c3e890c3223d2dd46c00bc4fe31eb2	["*"]	\N	2023-10-27 14:59:51	2023-10-27 14:59:51
412	App\\Models\\User	119	119user Oneuserone@gmail.com	6490ba5f4cf22221fcaca83250c332555103b43bc11878915e80581bcbd7ed5e	["*"]	\N	2023-10-27 14:59:51	2023-10-27 14:59:51
413	App\\Models\\User	120	120ghani 33ghanibro33@gmail.com	fca3431a5fb72dbf1181b25ad2340ab9894c911d674757dcb10fde004cf082a7	["*"]	\N	2023-10-27 15:01:45	2023-10-27 15:01:45
414	App\\Models\\User	120	120ghani 33ghanibro33@gmail.com	63eea3ac60968cb3d5518195503a95998b81d11096cb040ccf63141e6f60d08c	["*"]	\N	2023-10-27 16:21:19	2023-10-27 16:21:19
415	App\\Models\\User	84	84D X Technologiesdxbapps@yopmail.com	ceffcb7d9f403471158f55613f54d7e8ac014a4613af2bc1a257c99eb717c09f	["*"]	\N	2023-11-07 10:58:55	2023-11-07 10:58:55
416	App\\Models\\User	114	114Samsam@yopmail.com	2b0b2b0b8092c91537372a6570dc540ed9530bb184b4c9a8d6d9e89cb0c7534c	["*"]	\N	2023-11-07 11:04:15	2023-11-07 11:04:15
417	App\\Models\\User	111	111Mathewmathew@yopmail.com	aa5330ec443f3a97aefa7f1863e9bddc367b1c2c8bd7bb90bdbc974523a49581	["*"]	\N	2023-11-07 11:05:43	2023-11-07 11:05:43
418	App\\Models\\User	107	107Paulpaul@yopmail.com	cc13685b0e5b98508afb3c69bbab0308434f63ff328f76571f0a89ebccb2a619	["*"]	\N	2023-11-07 11:12:06	2023-11-07 11:12:06
419	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	a61ee5f30d0eb65d7fa327f94f37478cee100f73aa9a6d4bf3ee0cac46b13389	["*"]	\N	2023-11-09 11:07:23	2023-11-09 11:07:23
420	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	f9ee5f5cba66c566c2d8c132ae70d78c035185f222fc392ebcf2bbf3180ee59a	["*"]	\N	2023-11-09 11:12:56	2023-11-09 11:12:56
421	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	606696a5135e79c26fb143a855616c1e371bd41991d9767de1afeeb9c9baf286	["*"]	\N	2023-11-09 12:39:49	2023-11-09 12:39:49
422	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	892eab41b8e582fee4390825c567303608b74a80962290a861d889fbda796a89	["*"]	\N	2023-11-10 10:46:11	2023-11-10 10:46:11
423	App\\Models\\User	121	121more moretestdxbuae@gmail.com	a9c63a929ec9b8bec71bc104bd711c306e85e7983b8ff19858eb8a270e4b0db7	["*"]	\N	2023-11-10 11:14:11	2023-11-10 11:14:11
424	App\\Models\\User	121	121more moretestdxbuae@gmail.com	11264b48b32b4df47afb3720d15724d123ad1568ed19d80092cb62f05d1097ff	["*"]	\N	2023-11-10 11:17:42	2023-11-10 11:17:42
425	App\\Models\\User	121	121more moretestdxbuae@gmail.com	527afe1253898d30fbe37d00644bfa3ced8df97f0937ce64f9b47750873f29e5	["*"]	\N	2023-11-10 11:22:50	2023-11-10 11:22:50
426	App\\Models\\User	121	121more moretestdxbuae@gmail.com	87f4ce8f41966aac50143686478d172e8623d3feb934481b574c5d952ce1e932	["*"]	\N	2023-11-10 11:27:28	2023-11-10 11:27:28
427	App\\Models\\User	83	83Binsha1testdriver@gmail.com	48467c9ccf70385c53274dbd03bcc3652c956027e3ae3ee907cc0d4fbdb967da	["*"]	\N	2023-11-10 11:50:33	2023-11-10 11:50:33
428	App\\Models\\User	122	122rusvinrusvinmerak@gmail.com	11d3f1c70de67b6a56901393cf534510953e7fc7a46c4d10e8cc9f6a81585f27	["*"]	\N	2023-11-10 13:09:50	2023-11-10 13:09:50
429	App\\Models\\User	83	83Binsha1testdriver@gmail.com	4d2745babca459cc7b68e4c03c33bd9f3bc5d7dc5b198f39f3607b898a5acbe7	["*"]	\N	2023-11-10 13:09:54	2023-11-10 13:09:54
430	App\\Models\\User	123	123rusvinkrusvinmerak1@gmail.com	6f4fcbfc649604a89a07772eed3cc2d7abdd3ccfde3c87e2ec1d03732e08ad98	["*"]	\N	2023-11-10 13:11:44	2023-11-10 13:11:44
431	App\\Models\\User	123	123rusvinkrusvinmerak1@gmail.com	b3aab4735453662295b03c04295ded949902a7f75b51ca9fc894b07fe2e64c06	["*"]	\N	2023-11-10 13:15:13	2023-11-10 13:15:13
432	App\\Models\\User	123	123rusvinkrusvinmerak1@gmail.com	54c160c14d15c62ba2918e7ab3816ca66c427a78b1c3e1cfe75fb5634dbf93c6	["*"]	\N	2023-11-10 13:19:18	2023-11-10 13:19:18
433	App\\Models\\User	83	83Binsha1testdriver@gmail.com	43322b459ef12f91287d642118934b3c9cbe2c003ef5f869053726df53152027	["*"]	\N	2023-11-10 13:31:23	2023-11-10 13:31:23
434	App\\Models\\User	124	124rusvinkrusvinmerak2@gmail.com	a31de4e21ed2c2d5fb6ffb76047fe583edd3f3cba71f746493d37264d4c572b2	["*"]	\N	2023-11-10 13:31:25	2023-11-10 13:31:25
435	App\\Models\\User	123	123rusvinkrusvinmerak1@gmail.com	0c34e81fa39e49bdd54e0f2f4e94af24c3321897d89b7bd39a26f9f335766218	["*"]	\N	2023-11-10 13:31:42	2023-11-10 13:31:42
436	App\\Models\\User	123	123rusvinkrusvinmerak1@gmail.com	dcc4987102a04bb1d7181c8225b3e82dc649a09ad66ceb2b0463c657f2e423cc	["*"]	\N	2023-11-10 13:31:53	2023-11-10 13:31:53
437	App\\Models\\User	122	122rusvinrusvinmerak@gmail.com	cc9542e4bb3fc7ca74bbc4a04f2e1253163c69eb4d4cce0015b314b14b670eec	["*"]	\N	2023-11-10 13:31:59	2023-11-10 13:31:59
438	App\\Models\\User	125	125rusvinkrusvinmerak123@gmail.com	7ac17ad5e858edd428290b1bc446e0b0a8b691065807ccfaa21fc347393c811a	["*"]	\N	2023-11-10 13:32:08	2023-11-10 13:32:08
439	App\\Models\\User	126	126rusvinkrusvik1213@gmail.com	df3dd7d7f9f67f2fa29329366f2b1c366273fb156af3d47bf6796a12bf729974	["*"]	\N	2023-11-10 13:35:12	2023-11-10 13:35:12
440	App\\Models\\User	127	127rusvinkrusvik213@gmail.com	a5822b2f6cfaf07e9f57512d6fd8ed7f5115591d716ceff1adc62633ec207071	["*"]	\N	2023-11-10 13:35:20	2023-11-10 13:35:20
441	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	e945c1c1e700cfd3b32983536baacc4ac5c80e5294bbdb60d1dfbc8938b8a40b	["*"]	\N	2023-11-10 14:26:38	2023-11-10 14:26:38
442	App\\Models\\User	127	127rusvinkrusvik213@gmail.com	de7d0debcb8643922edc8a0293a68a0370b1572685d06e9436bb62ba92eff783	["*"]	\N	2023-11-10 14:36:03	2023-11-10 14:36:03
443	App\\Models\\User	122	122rusvinrusvinmerak@gmail.com	bb167f5ed970af54a46e00a7e25598119d2595624f8443199367dc599d7eab38	["*"]	\N	2023-11-10 14:36:13	2023-11-10 14:36:13
444	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	2b3ff816349ad9650a99a29d5b62fb430ac6c7da1d248a54236ed4ed7e074873	["*"]	\N	2023-11-10 19:47:35	2023-11-10 19:47:35
445	App\\Models\\User	121	121more moretestdxbuae@gmail.com	8990154b3be9d497b7a974b1656f739b9d37bf59e0c576008afd9ee542440dba	["*"]	\N	2023-11-10 20:59:26	2023-11-10 20:59:26
446	App\\Models\\User	121	121more moretestdxbuae@gmail.com	03e052eae800ab8c8831d9493435a9f4aadb9083cd5776f829fd53c69c034356	["*"]	\N	2023-11-10 21:13:28	2023-11-10 21:13:28
447	App\\Models\\User	121	121more moretestdxbuae@gmail.com	4db76f3c0cf956a7a957c7c4f2e4e2ee65db36253415fe3363b49d9c1acc8076	["*"]	\N	2023-11-10 21:18:19	2023-11-10 21:18:19
448	App\\Models\\User	121	121more moretestdxbuae@gmail.com	673ac92a7dbdb42531781b3e617003cd569718a5431f17efce626ff44e539f70	["*"]	\N	2023-11-10 21:19:44	2023-11-10 21:19:44
449	App\\Models\\User	121	121more moretestdxbuae@gmail.com	27f0c24139e5606c81afec582dfe60a83c9e1fb8dabaddaf99bbb8af9894aea1	["*"]	\N	2023-11-10 21:21:45	2023-11-10 21:21:45
450	App\\Models\\User	121	121more moretestdxbuae@gmail.com	a641c538f044744cee5649eda0a0256f5cd6198621e5feabf4e426d04e435bcd	["*"]	\N	2023-11-10 21:25:21	2023-11-10 21:25:21
451	App\\Models\\User	121	121more moretestdxbuae@gmail.com	9bcd81b7f53a3bb96093bfeb3d5c9cd840b8486832dd1077b07b15914209860f	["*"]	\N	2023-11-10 21:26:27	2023-11-10 21:26:27
452	App\\Models\\User	121	121more moretestdxbuae@gmail.com	c27368f978bd11279815b0d556cd9493dd2edc236caba5b7660dfe58d126bc54	["*"]	\N	2023-11-10 21:27:57	2023-11-10 21:27:57
453	App\\Models\\User	121	121more moretestdxbuae@gmail.com	cc2dcdea58020e3879c31e771bc5cbd22e0b935ef28699d48dfb61cffafb5389	["*"]	\N	2023-11-10 21:28:51	2023-11-10 21:28:51
454	App\\Models\\User	121	121more moretestdxbuae@gmail.com	bf699b3c070df93d4a6d545e5483837605cc08ddaebdaf7b5036c04854fc22d8	["*"]	\N	2023-11-10 21:31:22	2023-11-10 21:31:22
455	App\\Models\\User	121	121more moretestdxbuae@gmail.com	4782b0ecb12939a88acd761bbec17ac4dbf6b3b529b8e3086fc6856b8ba309fd	["*"]	\N	2023-11-10 21:32:40	2023-11-10 21:32:40
456	App\\Models\\User	121	121more moretestdxbuae@gmail.com	62e39ad4c67543ea73ce2801b79319d605dffa89b29c031f1da7679028f749fd	["*"]	\N	2023-11-10 21:35:34	2023-11-10 21:35:34
457	App\\Models\\User	121	121more moretestdxbuae@gmail.com	81d610ac7d581cb2c9fd454e143c9808eb3b87b0bf375aee1fd71ee30e0dbc18	["*"]	\N	2023-11-10 21:37:50	2023-11-10 21:37:50
458	App\\Models\\User	121	121more moretestdxbuae@gmail.com	7314c89e3d1796218ccf1e42f7b143ca406f9ae2b2f310a02c52bb2e941b1115	["*"]	\N	2023-11-10 21:39:17	2023-11-10 21:39:17
459	App\\Models\\User	121	121more moretestdxbuae@gmail.com	b80d8d994cd74cc6bdf5771ff5e66de05fd5ba4a261aa0486c9d602f8e7b86e8	["*"]	\N	2023-11-10 21:49:19	2023-11-10 21:49:19
460	App\\Models\\User	121	121more moretestdxbuae@gmail.com	3427419c0464bcaaf953c7152989706d687d36481c37f30b5469ce30ada1eac1	["*"]	\N	2023-11-10 21:51:25	2023-11-10 21:51:25
461	App\\Models\\User	121	121more moretestdxbuae@gmail.com	7a44529351d97be85f9cbd61a74ee6221d26474187d2db2659cfe9dbaaeb56ed	["*"]	\N	2023-11-10 21:55:26	2023-11-10 21:55:26
462	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	b702871299bf5e132cec354916ca1c9e9c1ccf936112745c936ca38eca94cbaa	["*"]	\N	2023-11-10 21:58:20	2023-11-10 21:58:20
463	App\\Models\\User	121	121more moretestdxbuae@gmail.com	3a9cdd7b7826ea0b4d2fbf4027261db4da1757217c4e247ef0ea7b8e642722e3	["*"]	\N	2023-11-10 22:10:35	2023-11-10 22:10:35
464	App\\Models\\User	121	121more moretestdxbuae@gmail.com	b9cb7ae1129aadc9678fe5ef94ecdff43d0675ec312e66e0eb372e24e01942f5	["*"]	\N	2023-11-10 22:14:16	2023-11-10 22:14:16
465	App\\Models\\User	121	121more moretestdxbuae@gmail.com	8d899353cd1c32910c2b566bc9b7d2dc48a2ff27f28330687b347be7737d8b9b	["*"]	\N	2023-11-10 22:25:48	2023-11-10 22:25:48
466	App\\Models\\User	128	Personal Access Token	66346fc4395351ba73ab74be6ce8f9ae65dfbfa3917ae6ed55991a6ba4ecf5c2	["*"]	\N	2023-11-11 00:09:49	2023-11-11 00:09:49
467	App\\Models\\User	128	128testtestdriver8@gmail.com	21568abb54580d35d492d85e5020afe4ed78f7cf29eaa1370923412f4c208e3c	["*"]	\N	2023-11-11 00:09:49	2023-11-11 00:09:49
468	App\\Models\\User	129	Personal Access Token	c16f5c049b0c92f3f57534352cd66ed8ff29339cb162a22152780d64e1c8b723	["*"]	\N	2023-11-11 00:13:06	2023-11-11 00:13:06
469	App\\Models\\User	129	129testtestdriver9@gmail.com	e7afb2f1297f40f2a0922aa023daf0d527afe857bcd232e66596bc551cf8b71e	["*"]	\N	2023-11-11 00:13:06	2023-11-11 00:13:06
470	App\\Models\\User	130	Personal Access Token	d7c0172c04698058bf08bc1f407593c639c2afc3de559f3410f4be532bb53f87	["*"]	\N	2023-11-11 00:15:33	2023-11-11 00:15:33
471	App\\Models\\User	130	130testtestdriver10@gmail.com	77508f5747bf6ec6fbf73a09d185af0461529646339579cc9d7063c4265c04f5	["*"]	\N	2023-11-11 00:15:33	2023-11-11 00:15:33
472	App\\Models\\User	83	83Binsha1testdriver@gmail.com	2079576b4258f835b851151f4656e036c5932bae3737c806d2146e0ccb53dd9f	["*"]	\N	2023-11-11 00:17:53	2023-11-11 00:17:53
473	App\\Models\\User	132	Personal Access Token	8d78729d529489115e21c2375b3ada54e6cdae349f53683148c628e178ab84b1	["*"]	\N	2023-11-11 13:56:08	2023-11-11 13:56:08
474	App\\Models\\User	132	132karankj01@mailinator.com	dcaa2787cfcf4f83668a444d02750eeb1cbd92788ad6462d96093816efbe2438	["*"]	\N	2023-11-11 13:56:08	2023-11-11 13:56:08
475	App\\Models\\User	104	104Danish Nisardaani4900@gmail.com	876fce2cf0f88088c6beedcc7ee5a2ede2c3ee3c68a093379021033f69109b9a	["*"]	\N	2023-11-11 14:11:51	2023-11-11 14:11:51
476	App\\Models\\User	97	97Driver Onedriver1@yopmail.com	808bf782c28143256c3a71259bc042f61f48b5a06f64a1a455d638632882c65f	["*"]	\N	2023-11-11 14:13:52	2023-11-11 14:13:52
477	App\\Models\\User	133	Personal Access Token	0e76f663c0b837a58fd819fbd723f4aecff74f1c44d2c73b454d66b8d5f62605	["*"]	\N	2023-11-11 21:15:29	2023-11-11 21:15:29
478	App\\Models\\User	133	133karankaranjaiswl@gmail.com	f4994eb14dd3614d6834ee66108a20a88548e2288c146c3af096c775fd896dd9	["*"]	\N	2023-11-11 21:15:29	2023-11-11 21:15:29
479	App\\Models\\User	133	133karankaranjaiswl@gmail.com	cb395802c9ae19b37701252e6c128195603edd8ed024b8cfef905bd562ee89ce	["*"]	\N	2023-11-11 21:15:29	2023-11-11 21:15:29
480	App\\Models\\User	134	134DX Appappdx0911@gmail.com	8bb4bfe6c324b21b891175c4d758b6cd55a61565c3f388a8af9c2fe135b1c02e	["*"]	\N	2023-11-11 21:32:12	2023-11-11 21:32:12
481	App\\Models\\User	134	134DX Appappdx0911@gmail.com	42c17c91cf81c61fb79fddbc4f929fb16a8eb91f6ecdc50cae0c61480667a14d	["*"]	\N	2023-11-11 21:34:13	2023-11-11 21:34:13
482	App\\Models\\User	134	134DX Appappdx0911@gmail.com	926944915a359f3f0a45fb68c697ea22cf3d72a4d08356f6256ea2471bf159a9	["*"]	\N	2023-11-11 21:35:13	2023-11-11 21:35:13
483	App\\Models\\User	135	135Nemai Biswas II Software Testernemai@dxbusinessgroup.com	963de4c6c361642452d9cc13a643b6c53e62025d2d14becbda29293ae9144866	["*"]	\N	2023-11-11 21:50:48	2023-11-11 21:50:48
484	App\\Models\\User	135	135Nemai Biswas II Software Testernemai@dxbusinessgroup.com	9d824e6e700bb0cfa251065846338d0764ec510e118e99198bd156ae42ebd8f4	["*"]	\N	2023-11-11 21:56:21	2023-11-11 21:56:21
485	App\\Models\\User	121	121more moretestdxbuae@gmail.com	613fab6e4755832cc210d1ff03294660684c388cab021f2a80e7acf44c9444be	["*"]	\N	2023-11-11 23:03:01	2023-11-11 23:03:01
486	App\\Models\\User	136	Personal Access Token	f1a8d37fd4397ed376f49ba380d51d2033ffc5577190afe6db742a0e9a2ee97a	["*"]	\N	2023-11-12 15:23:08	2023-11-12 15:23:08
487	App\\Models\\User	136	136anilanilnavis@gmail.com	6f850c23ebe67ab52cf7c4bc0565b4fe45182aee14678ceca9c4850c56624bdb	["*"]	\N	2023-11-12 15:23:08	2023-11-12 15:23:08
488	App\\Models\\User	137	Personal Access Token	81bf0c5ca88c28d2a5459d03731a743dd31d8c1cde5fbfe66e4a55247eaff9e8	["*"]	\N	2023-11-12 15:27:04	2023-11-12 15:27:04
489	App\\Models\\User	137	137Dxb cargoanil@dxbusinessgroup.com	c393e4ee766d908e299cac3251c40ce0ec9259feb67f2bf2908b9f5a76666cde	["*"]	\N	2023-11-12 15:27:04	2023-11-12 15:27:04
490	App\\Models\\User	137	137Dxb cargoanil@dxbusinessgroup.com	19d9a1a38f12715e78588aa7c5bc75bfc272ff7c0be457f0d5c5358b47ca1554	["*"]	\N	2023-11-12 15:27:04	2023-11-12 15:27:04
491	App\\Models\\User	126	126rusvinkrusvik1213@gmail.com	74c23fb63765a8cb51056bb1daf0c420aef871912582231917220fc0fe177027	["*"]	\N	2023-11-13 08:49:41	2023-11-13 08:49:41
492	App\\Models\\User	122	122rusvinrusvinmerak@gmail.com	32ef2c55420fe82f77b5bda39cdbb09c86e095a77a1f2e3ec3d4b7998be19f78	["*"]	\N	2023-11-13 08:50:00	2023-11-13 08:50:00
493	App\\Models\\User	97	97Driver Onedriver1@yopmail.com	b78c9ea7f0a0194d74203373efbcd6d61933b007ebeb1df606cbe1eff0ad929d	["*"]	\N	2023-11-13 08:53:20	2023-11-13 08:53:20
494	App\\Models\\User	138	138test testtestingfordxb@gmail.com	3fd1ba272b3b55ad2fbf8cf79e61d1158ee5a1b3be64b341f9b605576d107ff9	["*"]	\N	2023-11-13 09:25:32	2023-11-13 09:25:32
495	App\\Models\\User	134	134DX Appappdx0911@gmail.com	39ebfb0bdc22610d91e772dcb8909f5effb0a560bbd7347ddbe2f0cec8fd748b	["*"]	\N	2023-11-13 09:30:11	2023-11-13 09:30:11
496	App\\Models\\User	122	122rusvinrusvinmerak@gmail.com	63268787de701939707554b42c7d975ebdae8fcaf74378305a308a65bfe442de	["*"]	\N	2023-11-13 09:33:58	2023-11-13 09:33:58
497	App\\Models\\User	121	121more moretestdxbuae@gmail.com	9807b6f579837457e87d0c8bc62ec7c272d408578630509150b0b89f2beea925	["*"]	\N	2023-11-13 09:34:40	2023-11-13 09:34:40
498	App\\Models\\User	121	121more moretestdxbuae@gmail.com	3935f9533f9fb1223d21962eaf02070675291505ef3abe445333b50b11c90070	["*"]	\N	2023-11-13 09:36:10	2023-11-13 09:36:10
499	App\\Models\\User	121	121more moretestdxbuae@gmail.com	a381ad921bb3f471662d7f561f06674907695be9faecc75b1fffc8b4e9afa850	["*"]	\N	2023-11-13 09:38:14	2023-11-13 09:38:14
500	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	77d724c54b4828c70f70a2fe60547477f574b0756cab133baca7aee00ae61888	["*"]	\N	2023-11-13 09:44:21	2023-11-13 09:44:21
501	App\\Models\\User	122	122rusvinrusvinmerak@gmail.com	34a4685176f3bce90b25b5fbf810a7442708463fba38ed8d3018097852080591	["*"]	\N	2023-11-13 09:44:34	2023-11-13 09:44:34
502	App\\Models\\User	139	Personal Access Token	c27d1db10fa14e0659fea48a178120a854ae623b7193e5677279fdfdfcac4e97	["*"]	\N	2023-11-13 09:48:33	2023-11-13 09:48:33
503	App\\Models\\User	139	139NbDrivernbd1@mailinator.com	93c1fa266ba3c25269bbb539c9bc92e33ad555a842b5ab160088215cb6fa115a	["*"]	\N	2023-11-13 09:48:33	2023-11-13 09:48:33
504	App\\Models\\User	122	122rusvinrusvinmerak@gmail.com	e5161399c861b7a859cec3bc9f456509631693499e7b937c8d8dcdeeb0c31bd9	["*"]	\N	2023-11-13 09:49:07	2023-11-13 09:49:07
505	App\\Models\\User	121	121more moretestdxbuae@gmail.com	946523776dc710c1063b480cfdb7572ca099a030fc173fd06fdde1d5e9be4550	["*"]	\N	2023-11-13 09:50:20	2023-11-13 09:50:20
506	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	01b95c77602372b110a967e678fce2ccfa2e67bcf88243d6b4fbeb53d441ab02	["*"]	\N	2023-11-13 10:03:25	2023-11-13 10:03:25
507	App\\Models\\User	140	Personal Access Token	572aaf4b2a0fda69d7dce477a58e2fc1548c13f2f86d541b847b18b95b52f8bf	["*"]	\N	2023-11-13 10:07:04	2023-11-13 10:07:04
508	App\\Models\\User	140	140hunain sevenhunain77@gmail.com	f1eb668861c2d6b7d20a13cc29b800c6f6dfcd100e6d56ff237a37c869f8395b	["*"]	\N	2023-11-13 10:07:04	2023-11-13 10:07:04
509	App\\Models\\User	140	140hunain sevenhunain77@gmail.com	3ae8f398bee442b540076d4a099d5c2fd1353f6ed9bb3cfa45d7dbc2c18a2705	["*"]	\N	2023-11-13 10:07:04	2023-11-13 10:07:04
510	App\\Models\\User	122	122rusvinrusvinmerak@gmail.com	e7bc9a9997915c01b97b896a088392b62674646c9c7557a70852ef3c80ea70f7	["*"]	\N	2023-11-13 10:13:03	2023-11-13 10:13:03
511	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	6080bff8ed02cc0e1b3c2ccf65b77b1f763ffe04a509572273cb8f494b7945a5	["*"]	\N	2023-11-13 10:40:05	2023-11-13 10:40:05
512	App\\Models\\User	122	122rusvinrusvinmerak@gmail.com	19a4b1923d71980e56e84aff820f9c3fda0352cb98559588da34795e5068894d	["*"]	\N	2023-11-13 10:43:12	2023-11-13 10:43:12
513	App\\Models\\User	140	140hunain sevenhunain77@gmail.com	04c4e88f38360514d6de8e12806800da0ef69293b18404b1b026a44a2ff447ad	["*"]	\N	2023-11-13 10:59:57	2023-11-13 10:59:57
514	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	db446f863877ce45f4bb3b2d6d5040887e2f9154aa8379b4b61d2c54e461daf9	["*"]	\N	2023-11-13 11:17:30	2023-11-13 11:17:30
515	App\\Models\\User	140	140hunain sevenhunain77@gmail.com	4c2bfd325919cd0a6581ce6c19fb04993a57141c2b286c28c849a6e1bdad29ec	["*"]	\N	2023-11-13 11:33:06	2023-11-13 11:33:06
516	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	48e1a626c2f3870b23458ff37662b9553215410a3b9c56a6d008e8edfb63d008	["*"]	\N	2023-11-13 11:35:22	2023-11-13 11:35:22
517	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	08cde6a45528a865ba093b8bc0e12d9d6ca11f6c5e5a1d2140e32f9481ff57f0	["*"]	\N	2023-11-13 14:17:50	2023-11-13 14:17:50
518	App\\Models\\User	140	140hunain sevenhunain77@gmail.com	574bbdc37226ffe60d32667c4c62719a7480a511955fb6c6b6f185ec6d066e98	["*"]	\N	2023-11-13 15:26:56	2023-11-13 15:26:56
519	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	67b7a62dae794bc2ba66b1fc31c02f02effb2e221f45666a565c274474490e6d	["*"]	\N	2023-11-13 15:38:56	2023-11-13 15:38:56
520	App\\Models\\User	140	140hunain sevenhunain77@gmail.com	0733fcfe1cc60d3f28356d9ed59bc4f2761800ad260440bf56d343f8e328dd1a	["*"]	\N	2023-11-13 15:48:03	2023-11-13 15:48:03
521	App\\Models\\User	139	139NbDrivernbd1@mailinator.com	39681058021660744e69becf21e9defdd02da16601c6f01a3f1d25eb91bccf6b	["*"]	\N	2023-11-13 15:50:10	2023-11-13 15:50:10
522	App\\Models\\User	139	139NbDrivernbd1@mailinator.com	c61614dc4e9210de4edeb1665a30f35d39e1dc764293039f7ed2956fed32a25e	["*"]	\N	2023-11-13 15:50:50	2023-11-13 15:50:50
523	App\\Models\\User	122	122rusvinrusvinmerak@gmail.com	0553c3f8ede8873864e262675a505cae894402bf33dc950daf9fbc94eb3e1c8f	["*"]	\N	2023-11-13 16:03:48	2023-11-13 16:03:48
524	App\\Models\\User	83	83Binsha1testdriver@gmail.com	5d1671d4c2ecf4d61fed96dc47a6a30edcbd32e6c539f7e2e8c8b63074014cec	["*"]	\N	2023-11-13 16:13:05	2023-11-13 16:13:05
525	App\\Models\\User	141	Personal Access Token	20f855d3c08f93d83c56a691ee63c0d49caba3fe004143cee730413f5bda7314	["*"]	\N	2023-11-13 17:01:20	2023-11-13 17:01:20
526	App\\Models\\User	141	141Karankaranjaiswa@gmail.com	103a626a0cb672f3dba423ff95f99a1c70f879e5b04df5b21097b681a977b913	["*"]	\N	2023-11-13 17:01:20	2023-11-13 17:01:20
527	App\\Models\\User	141	141Karankaranjaiswa@gmail.com	d9f57cf7ae8e58a862b951fdc1ef532b945ba09f2e8846e67ff24871b41937c9	["*"]	\N	2023-11-13 17:01:20	2023-11-13 17:01:20
528	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	6443fd94dcfa514c5801a8721c8a6cfde63c6324f014965b7a375bd9f471835b	["*"]	\N	2023-11-13 17:32:53	2023-11-13 17:32:53
529	App\\Models\\User	139	139NbDrivernbd1@mailinator.com	be49f4dbcc6ab535afe9c9130ccc390dc490c5d055d4c3fc36a7cab879623332	["*"]	\N	2023-11-13 18:04:40	2023-11-13 18:04:40
530	App\\Models\\User	139	139NbDrivernbd1@mailinator.com	8901e98a019037bb018d6ab3c50aad2fbcaf4c6fda825ea33053e96aa84b8296	["*"]	\N	2023-11-13 18:05:03	2023-11-13 18:05:03
531	App\\Models\\User	142	Personal Access Token	32a01be0dcc10d423f8a5fe0010c1a5b8d1c10bb87bca2d4ee5bd87761faa8a0	["*"]	\N	2023-11-13 18:30:14	2023-11-13 18:30:14
532	App\\Models\\User	142	142testkaranjais6@gmail.com	3182b0d429c349466812d29ac5cfa5e25d2c2d105b201568b5eb4dd7a96fefbf	["*"]	\N	2023-11-13 18:30:14	2023-11-13 18:30:14
533	App\\Models\\User	142	142testkaranjais6@gmail.com	33ba74afef99f46963895d28e18ea601ccb542ffdf072aea0eb0e75cfbc939ab	["*"]	\N	2023-11-13 18:30:14	2023-11-13 18:30:14
534	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	92582b62ccc18ac05925b611f69d8e17dbc62ab2d63baaeb68e79d9fdc67aeaa	["*"]	\N	2023-11-13 19:34:46	2023-11-13 19:34:46
535	App\\Models\\User	140	140hunain sevenhunain77@gmail.com	de5c1b552783545c713ebb5374b01c7c44374bdc7c98130c005fda0701909785	["*"]	\N	2023-11-13 20:36:00	2023-11-13 20:36:00
536	App\\Models\\User	143	Personal Access Token	29d2afe1490d77d3109e7bc4e28480671f841202d18d441d5b5984d6924f05b7	["*"]	\N	2023-11-13 21:12:03	2023-11-13 21:12:03
537	App\\Models\\User	143	143test sixhunain66@gmail.com	4f43bbb51ce4bd8247b3b8cc5135aa67728886d2c89882b6a58aac602f020c1e	["*"]	\N	2023-11-13 21:12:04	2023-11-13 21:12:04
538	App\\Models\\User	143	143test sixhunain66@gmail.com	53e451c00240fcf47632a0b4ac0e5937c25ab48fb8d4ecb00865455dd22ffdb6	["*"]	\N	2023-11-13 21:12:04	2023-11-13 21:12:04
539	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	7c16e5fb39dacb3d7fcfd942890124c88e0cca4d76d57f9e46dca5ff6d0aea48	["*"]	\N	2023-11-13 21:37:55	2023-11-13 21:37:55
540	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	76c37e24116975077020c1622373ad991620d4e8a7b7cbbf0e2fb1342cd90344	["*"]	\N	2023-11-13 21:49:34	2023-11-13 21:49:34
541	App\\Models\\User	143	143test sixhunain66@gmail.com	a13cc23ee76a27c47e6668e46ca2b21c4e388dcbaec2d5fbbbe60427ea3be8a8	["*"]	\N	2023-11-13 23:56:41	2023-11-13 23:56:41
542	App\\Models\\User	144	Personal Access Token	c3e88e15d1a5e3543e4f9688f09daeb3fe61ca0c89c64ce5ec538a4a54269fde	["*"]	\N	2023-11-14 00:48:58	2023-11-14 00:48:58
543	App\\Models\\User	144	144testtestdriver20@gmail.com	9a785612314faf344359d10e243837ec3c8bc9146b9c1d618aa1bd5d7195d1a4	["*"]	\N	2023-11-14 00:48:58	2023-11-14 00:48:58
544	App\\Models\\User	130	130testtestdriver10@gmail.com	1c4d57d35fbd5ff72e85f6ec79ddf5ff9e2846dd6b7f1b4383326883d0815a39	["*"]	\N	2023-11-14 00:52:58	2023-11-14 00:52:58
545	App\\Models\\User	129	129testtestdriver9@gmail.com	94fedd7236fe06a1563392c28518a64a2d1ea9b3775328f421b451c6af768568	["*"]	\N	2023-11-14 01:30:27	2023-11-14 01:30:27
546	App\\Models\\User	73	73Hunain Dehunain88@gmail.com	b88478a5c440b35a47b084f29596eeefa2894a89a521a36d20b4a131417a56cb	["*"]	\N	2023-11-14 09:34:12	2023-11-14 09:34:12
547	App\\Models\\User	83	83Binsha1testdriver@gmail.com	fd8f0c836b91e308c0d9c08d3d1e9ab80e99827d35ce260ff037accff8930043	["*"]	\N	2023-11-14 09:42:01	2023-11-14 09:42:01
548	App\\Models\\User	139	139NbDrivernbd1@mailinator.com	7c7b3b15f9562cb978b8fcdc242eff58b3b746b0e73444ddb3a34e0bb9a73f9c	["*"]	\N	2023-11-14 09:51:08	2023-11-14 09:51:08
549	App\\Models\\User	89	89test threetestdriver3@gmail.com	337c190fa170ed48a8ea286811bef6d42e97a910fb9b4a206a36a398ed077529	["*"]	\N	2023-11-14 12:27:32	2023-11-14 12:27:32
550	App\\Models\\User	98	98Driver Twodriver2@yopmail.com	d4b2294db22d302fd966b0cda00c5174928845c019e5b90e9adf844a32e4f3d9	["*"]	\N	2023-11-14 12:29:33	2023-11-14 12:29:33
551	App\\Models\\User	111	111Mathewmathew@yopmail.com	f719b53f5e39f23c85d4389547fac2912083e135abd6cca49f558e2e9362e1b5	["*"]	\N	2023-11-14 12:38:36	2023-11-14 12:38:36
552	App\\Models\\User	142	142testkaranjais6@gmail.com	bd9dc188fadc9520a1e5c542289925216dd93fea744b26d5bd65315194f5d1b8	["*"]	\N	2023-11-14 12:44:32	2023-11-14 12:44:32
553	App\\Models\\User	145	Personal Access Token	2f6f5ca043e966696df1f32d38bd6a20e1d338b17c7b75c2c85eea8533aa1e37	["*"]	\N	2023-11-14 12:55:16	2023-11-14 12:55:16
554	App\\Models\\User	145	145NB Comnbu1@mailinator.com	754f6f1aec5b0b7dabc5b311d9042f185b8facc1571849cfe78c613cbbc6ab31	["*"]	\N	2023-11-14 12:55:16	2023-11-14 12:55:16
555	App\\Models\\User	145	145NB Comnbu1@mailinator.com	6096432b2f76df02337fcd242612f1389c4a8641a8a66c7eb2bf00f7fa8bf8db	["*"]	\N	2023-11-14 12:55:16	2023-11-14 12:55:16
556	App\\Models\\User	146	Personal Access Token	c1e117d490a3486361b7194b2a033f8b00c474b1442e5bc09da91ec46a5032c0	["*"]	\N	2023-11-14 13:07:47	2023-11-14 13:07:47
557	App\\Models\\User	146	146Testtkaranjai@gmail.com	c3a8b237cedcc9484f8a5083795dd97098bcb759260a9dbec8ec752a54738c7f	["*"]	\N	2023-11-14 13:07:47	2023-11-14 13:07:47
558	App\\Models\\User	146	146Testtkaranjai@gmail.com	41d45d1fb2d79832e9e0a5745377e74413a4acff595666a55686424be2da9210	["*"]	\N	2023-11-14 13:07:47	2023-11-14 13:07:47
\.


--
-- Data for Name: role_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.role_permissions (permission_id, user_role_id_fk, module_key, permissions, created_at, updated_at) FROM stdin;
1	5	dashboard	["r"]	\N	\N
2	5	drivers	["c","r","u","d"]	\N	\N
3	5	customers	["c","r","u","d"]	\N	\N
4	5	bookings	["c","r","u","d"]	\N	\N
5	5	earnings	["c","r","u","d"]	\N	\N
6	5	reviews	["c","r","u","d"]	\N	\N
7	5	reports	["c","r","u","d"]	\N	\N
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, role, is_admin_role, status, created_at, updated_at, deleted_at) FROM stdin;
1	Admin	1	active	2023-07-25 19:46:45	2023-07-25 19:46:45	\N
2	Truck Driver	0	active	2023-07-25 19:46:45	2023-07-25 19:46:45	\N
3	Customer	0	active	2023-07-25 19:46:45	2023-07-25 19:46:45	\N
4	Company	0	active	2023-07-25 19:46:45	2023-07-25 19:46:45	\N
5	Admin Manager	1	active	2023-10-27 10:25:19	2023-10-27 10:25:19	\N
\.


--
-- Data for Name: settings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.settings (id, contact_number, whatsapp_number, created_at, updated_at) FROM stdin;
1	+971 564005096	+971 564005096	2023-10-20 11:18:31	2023-10-25 16:34:23
\.


--
-- Data for Name: shipping_methods; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.shipping_methods (id, name, icon, status, created_at, updated_at) FROM stdin;
1	Fedex	64c0b9e5de12c_1690352101.png	active	2023-07-26 10:15:01	2023-07-26 10:15:01
\.


--
-- Data for Name: spatial_ref_sys; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.spatial_ref_sys (srid, auth_name, auth_srid, srtext, proj4text) FROM stdin;
\.


--
-- Data for Name: storage_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.storage_types (id, name, status, created_at, updated_at) FROM stdin;
2	General warehouse (Non AC)	active	2023-08-04 15:38:12	2023-08-04 15:38:12
1	Cold Storage	active	2023-08-04 15:36:01	2023-10-26 11:31:39
\.


--
-- Data for Name: temp_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.temp_users (temp_user_id, truck_type, account_type, name, email, password, dial_code, phone, driving_license, company_id, emirates_id_or_passport, emirates_id_or_passport_back, user_device_type, user_device_token, user_device_id, driving_license_number, driving_license_expiry, driving_license_issued_by, vehicle_plate_number, vehicle_plate_place, mulkiya, mulkiya_number, status, address, country, city, zip_code, latitude, longitude, created_at, updated_at, address_2, role_id, country_id, city_id, user_phone_otp) FROM stdin;
4	2	0	Abdul Ghani	ghaniabro111@gmail.com	abc123	+971	33838383	\N	5	\N	\N	android	882828282	12122112	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2023-08-15 10:18:47	2023-08-15 10:18:47	\N	0	0	0	0
150	2	0	Muzammal	faridmuzammal7675@gmail.com	Farid@123	92	3446867890	\N	\N	\N	\N	ANDROID	access_token	0c4144052565a266	\N	\N	\N	\N	\N	\N	\N	\N	Business Bay	United Arab Emirates	Dubai	\N	31.55581512	74.27937347	2023-08-17 23:35:24	2023-08-17 23:35:40	H74H+9P2, Captain Jamal Rd, Sanda Lahore, Punjab 54000, Pakistan,	0	0	0	0
107	2	1	Abdul Ghani	ghaniaaabro31@gmail.com	abc123	971	33838385	\N	38	\N	\N	android	882828282	12122112	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2023-08-16 22:43:16	2023-08-16 22:43:16	\N	0	0	0	0
183	2	0	android tester	android_driver@hotmail.com	Asdfghj@123	27	321456987	\N	0	\N	\N	ANDROID	asd	20a11c1f86eca55f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2023-09-07 11:40:38	2023-09-07 11:40:38	\N	0	0	0	0
114	3	1	rajitha	rajitha@gmail.com	Hello@123	971	551493643	\N	38	\N	\N	ANDROID	access_token	45a0e1ce1382dfba	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2023-08-17 09:17:32	2023-08-17 09:17:32	\N	0	0	0	0
65	2	0	rajita	Rajitharaji1998@gmail.com	Hello@123	971	551794838	\N	5	\N	\N	android	882828282	12122112	\N	\N	\N	\N	\N	\N	\N	\N	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	\N	\N	\N	25.18420692	55.25999263	2023-08-16 12:59:35	2023-08-16 12:59:42	\N	0	0	0	0
158	2	0	Muzammal	faridmuzammal775@gmail.com	Farid@123	92	3317958428	\N	\N	\N	\N	ANDROID	access_token	0c4144052565a266	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2023-08-18 01:21:18	2023-08-18 01:21:18	\N	0	0	0	0
159	2	0	Muzammal	faridmuzammal7577@gmail.com	Farid@123	27	3317958433	\N	\N	\N	\N	ANDROID	access_token	0c4144052565a266	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2023-08-18 01:26:27	2023-08-18 01:26:27	\N	0	0	0	0
161	2	0	Muzammal	faridmuzammal75kk@gmail.com	Farid@123	27	3317958499	\N	\N	\N	\N	ANDROID	access_token	0c4144052565a266	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2023-08-18 01:28:53	2023-08-18 01:28:53	\N	0	0	0	0
164	2	0	Muzammal	faridmuzammal7@gmail.com	Farid@123	27	33179584233	\N	\N	\N	\N	ANDROID	access_token	0c4144052565a266	\N	\N	\N	\N	\N	\N	\N	\N	Business Bay	United Arab Emirates	Dubai	\N	31.55581083	74.27936375	2023-08-18 01:33:42	2023-08-18 01:34:04	H74H+9P2, Captain Jamal Rd, Sanda Lahore, Punjab 54000, Pakistan,	0	0	0	0
165	2	0	Muzammal	faridmuzammal78@gmail.com	Farid@123	27	3317958422	\N	\N	\N	\N	ANDROID	access_token	0c4144052565a266	\N	\N	\N	\N	\N	\N	\N	\N	Business Bay	United Arab Emirates	Dubai	\N	31.55581426	74.27936912	2023-08-18 01:34:33	2023-08-18 01:34:45	H74H+9P2, Captain Jamal Rd, Sanda Lahore, Punjab 54000, Pakistan,	0	0	0	0
173	2	0	Muzammal Farid	faridmuzammal575@gmail.com	Farid@123	27	3317958777	\N	\N	\N	\N	ANDROID	access_token	0c4144052565a266	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2023-08-20 00:29:51	2023-08-20 00:29:51	\N	0	0	0	0
174	2	0	muzammal	faridmuzammal65675@gmail.com	Farid@123	27	3317958580	\N	\N	\N	\N	ANDROID	asd	0c4144052565a266	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2023-08-20 00:35:14	2023-08-20 00:35:14	\N	0	0	0	0
178	3	0	vxc	android_driver01@gmail.com	Farid@123	27	321456789	\N	0	\N	\N	ANDROID	asd	20a11c1f86eca55f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2023-09-01 20:25:14	2023-09-01 20:25:14	\N	0	0	0	0
179	2	0	muzammal farid	faridmuzammal7yyy5@gmail.com	Farid@123	27	333669999	\N	0	\N	\N	ANDROID	asd	0c4144052565a266	\N	\N	\N	\N	\N	\N	\N	\N	Business Bay	United Arab Emirates	Dubai	\N	31.55569455	74.28033303	2023-09-01 23:38:11	2023-09-01 23:38:47	H74J+877, Sanda Gulshan-e-Ravi, Lahore, Punjab 54000, Pakistan,	0	0	0	0
228	2	0	B test	niya@driver.com	Hello@1985	971	4546546546	\N	\N	\N	\N	android	882828282	12122112	\N	\N	\N	\N	\N	\N	\N	\N	Safa Park - Sheikh Zayed Rd - Al Safa - Dubai - United Arab Emirates	United Arab Emirates	Dubai	\N	25.18543449	55.24619408	2023-10-20 16:12:27	2023-10-20 16:12:41	ABC, DEF	0	0	0	0
182	2	1	Timex	timex@yopmail.com	Hello@1985	27	55134684894	\N	38	\N	\N	ANDROID	asd	e49f374a2b29c439	\N	\N	\N	\N	\N	\N	\N	\N	Business Bay	United Arab Emirates	Dubai	\N	25.18317928	55.27288701	2023-09-07 10:29:57	2023-09-07 10:30:39	Churchill Executive Tower - الخليج التجاري - دبي - United Arab Emirates,	0	0	0	0
187	\N	\N	K L Traders	kl@yopma.com	$2y$10$FUsb7p/ITH/EZGusi1XFhu6V5fHrsGTO73/sNXfOas1dnwpupjS/K	+971	552157894	\N	\N	\N	\N	ANDROID	deviceToken	3764434	\N	\N	\N	\N	\N	\N	\N	\N		\N	\N	1	\N	\N	2023-10-07 17:56:57	2023-10-07 17:57:03	ABC DEF	3	1	1	1111
188	\N	\N	D X Technologies	dxt@yopmail.com	$2y$10$kJHQmHObm1a2dm/p5fg2CeIi3YykYNPXdkPZKQmoAd0TZ2ZWhZm.W	+971	551525612	\N	\N	\N	\N	ANDROID	deviceToken	3764434	\N	\N	\N	\N	\N	\N	\N	\N		\N	\N	1	\N	\N	2023-10-07 17:59:33	2023-10-07 17:59:33	ABC DEF	3	1	1	1111
190	\N	\N	TST LLC	tst@yopmail.com	$2y$10$TWuy0feRn4tdCtnt.UjOfOAlBe35WrC/59Ep2qSjo3S9MphIVWdZy	+971	55428487878	\N	\N	\N	\N	ANDROID	deviceToken	3764434	\N	\N	\N	\N	\N	\N	\N	\N		\N	\N	1	\N	\N	2023-10-09 09:35:21	2023-10-09 09:35:21	ABC DEF	3	1	1	1111
235	\N	\N	TimeX User	timex@gmail.com	$2y$10$X84ICcDJ1zvpEfrHXotkYeQoTktYUOdJA0NZgNRhVayYAngT3d3NW	+971	3204504505	\N	\N	\N	\N	ANDROID	deviceToken	3764434	\N	\N	\N	\N	\N	\N	\N	\N		\N	\N	1	\N	\N	2023-10-24 17:22:55	2023-10-24 17:22:55	ABC DEF	3	1	1	1111
234	1	0	James	james@gmail.com	Hello@123	92	3204504502	\N	0	\N	\N	ANDROID	cUB4fo_YSxOCEp9wEhOYSu:APA91bFCxU3QoVmHm1bSXYvn9HSONOk7h4rsIKmoa1EuShkAqgzEesLtXATl3LiJqjcelVIKK78kywAwm6WTOLSEeDBbtk7RnIAsRu1fUzWj_3PGXdaADi1EKJ0CEKgZAMW43FK3fKy_	de53e8cce5a1c32d	\N	\N	\N	\N	\N	\N	\N	\N	Business Bay	United Arab Emirates	Dubai	\N	31.489153439337944	73.09940300881863	2023-10-24 11:41:10	2023-10-24 11:41:20	790 B Block, Millat Town Faisalabad, Punjab, Pakistan,	0	1	1	0
236	\N	\N	TimeX User	timexuser@gmail.com	$2y$10$q4aEffU8tDQfjUnCd4pgluq33PUHZKvoLz4ZmtH8a/dYzfBUHol4K	+971	3204504506	\N	\N	\N	\N	ANDROID	deviceToken	3764434	\N	\N	\N	\N	\N	\N	\N	\N		\N	\N	1	\N	\N	2023-10-24 17:29:16	2023-10-24 17:29:16	ABC DEF	3	1	1	1111
237	\N	\N	companyOne	company1@gmail.com	$2y$10$E9zhvePFqcNAWMIywyGGveT5ecVIQEWoW7Lsy22NPRakkaD/Onas.	+971	3204504507	\N	\N	\N	\N	ANDROID	deviceToken	3764434	\N	\N	\N	\N	\N	\N	\N	\N		\N	\N	1	\N	\N	2023-10-24 17:47:26	2023-10-24 17:47:26	ABC DEF	3	1	1	1111
246	1	0	Sardar	sardar1@gmail.com	Hello@123	971	7439520433	\N	0	\N	\N	ANDROID	cVNntqzOR2asBnU8VoaxuS:APA91bELVm2j9V8iG6Iz53niORarwI3sFzz_Y2CCRT0jJoH7ZKycwc7f8DyOA4NnKrwLCktCvOw_A7aQ85BPjfNCPrx1DG5JtRnCSEx5rOJCPC8Q6FoUjAKuM7xDIfV9vSgthaKDQs-v	81329b1f99e87327	\N	\N	\N	\N	\N	\N	\N	\N	Business Bay	United Arab Emirates	Dubai	\N	23.51826734377466	86.62494789808989	2023-11-07 11:10:46	2023-11-07 11:11:09	GJ9F+6W9, SH 5, Shanka, West Bengal 723133, India,	0	1	1	0
247	1	0	Sartaj Driving	drivera1@gmail.com	Hello@123	971	123456789	\N	0	\N	\N	ANDROID	cVNntqzOR2asBnU8VoaxuS:APA91bELVm2j9V8iG6Iz53niORarwI3sFzz_Y2CCRT0jJoH7ZKycwc7f8DyOA4NnKrwLCktCvOw_A7aQ85BPjfNCPrx1DG5JtRnCSEx5rOJCPC8Q6FoUjAKuM7xDIfV9vSgthaKDQs-v	81329b1f99e87327	\N	\N	\N	\N	\N	\N	\N	\N	Business Bay	United Arab Emirates	Dubai	\N	23.519963093070658	86.62882804870605	2023-11-08 07:58:03	2023-11-08 07:58:51	SH 5, Shanka, West Bengal 723133, India,	0	1	1	0
\.


--
-- Data for Name: truck_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.truck_types (id, truck_type, type, dimensions, icon, status, created_at, updated_at, max_weight_in_tons, is_container) FROM stdin;
2	1 Ton Side Grill	ltl	2*1*2	652fa54dda3a4_1697621325.jpeg	active	2023-07-25 19:47:59	2023-10-18 13:30:59	1	0
3	3 Ton Side Grill	ftl	4*5*8	6523949f0cca5_1696830623.jpg	active	2023-07-25 19:50:03	2023-10-18 13:31:40	3	0
1	1 Ton Box	ltl	2*1*2	65238ab4eb8c1_1696828084.jpg	active	2023-07-25 19:47:10	2023-10-18 13:31:57	1	0
4	20 Ft	ftl	2X1X2	653a59386512d_1698322744.jpg	active	2023-10-26 16:19:04	2023-10-26 16:19:04	16	1
5	20HC	ftl	2*1.1*1.1*1.0	653a59521ca7d_1698322770.jpg	active	2023-10-26 16:19:30	2023-10-26 16:19:30	21	1
6	40 Ft	ftl	4*1.85*1.80	653a596b07138_1698322795.jpg	active	2023-10-26 16:19:55	2023-10-26 16:19:55	26	1
7	40HC	ftl	4*1.85*1.8	653a597f2181a_1698322815.jpg	active	2023-10-26 16:20:15	2023-10-26 16:20:15	30	1
\.


--
-- Data for Name: user_password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_password_resets (id, email, token, is_valid, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: user_wallet_transactions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_wallet_transactions (id, user_wallet_id, amount, type, created_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: user_wallets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_wallets (id, user_id, amount, created_at, updated_at) FROM stdin;
1	16	0	2023-07-26 23:25:43	2023-07-26 23:25:43
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, dial_code, phone, phone_verified, password, email_verified_at, role_id, user_phone_otp, user_device_token, user_device_type, user_access_token, firebase_user_key, status, remember_token, created_at, updated_at, deleted_at, provider_id, avatar, address, profile_image, is_admin_access, latitude, longitude, country, city, zip_code, address_2, user_device_id, fcm_token, password_reset_otp, password_reset_time, login_type, country_id, city_id, trade_licence_number, trade_licence_doc, temp_dialcode, temp_mobile, usertype) FROM stdin;
145	NB Com	nbu1@mailinator.com	+971	987466666	1	$2y$10$i6hT3IFia9.JRBPUnB5qbu7huyj2VkHiVgOMQSYKBr3f7PCxnn8Em	\N	3		deviceToken	ANDROID	555|1O6BuygCLaCTXmLMrUZMuu9Etw88ecikhqjCsj2j	-NjC1gGrgw7YLRpYZBK5	active	\N	2023-11-14 12:55:16	2023-11-14 12:55:16	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
114	Sam	sam@yopmail.com	971	5468736925	0	$2y$10$wnX5ltngZoQkW8/aEC.3Euh8SfjdQCebXhr0.a9HWLiCU5p8F0oqS	\N	2	1111		ANDROID		-Nhk-Hf1t1XKWfwt3fha	active	\N	2023-10-27 07:20:06	2023-11-07 07:09:12	\N	\N	\N	Business Bay	\N	0	25.184232104533816	55.25999128818512	United Arab Emirates	Dubai	\N	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	30eb4e7290d67788	\N	\N	\N	normal	0	0	\N	\N	91	7439520433	0
83	Binsha1	testdriver@gmail.com	971	123528084	1	$2y$10$YNS5hGRkROOaVaVCIMORPeSjECwyzf4LADBVo3ngX8Yo0LkmI5kc2	2023-10-26 15:38:37	2		e453ezZ2R0GGK9kt0-PClC:APA91bEkGWeBsUEYMULgPNf5e1O2_lMvxN5E_IC38OLBeILXsR4V-LHbehmS0YjI8gl4BRTAaX4lFTe7fa_RUfqP5L7vE_ITewrpeU8h3S-ihLpdYlTJ59krvn6-bOxL30XcKuUXQzq2	ANDROID	547|KsvQP9UMEu9YhgBCQOZibWGIxlMj94Cd3akYh9j4	-NgwCVpgsYI3TG3B7Z5R	active	\N	2023-10-10 05:35:10	2023-11-14 09:42:02	\N	\N	\N	8CP3+CP7 - Industrial Area_4 - Industrial Area - Sharjah - United Arab Emirates	653a81db9f07c_1698333147.jpg	0	25.3362176	55.4041344	United Arab Emirates	Dubai	88	H48P+PP4, Block A Police Foundation, Islamabad, Punjab, Pakistan,	507c25ffbc01d8ae	\N	\N	\N	normal	0	0	\N	\N			0
97	Driver One	driver1@yopmail.com	971	25442589633	0	$2y$10$l2uQ/o9nmJKjcDzzfD0DdO1p.e6H6W63.9ky1saKt1UjdFY/bJyGO	2023-11-11 14:13:09	2	1111		ANDROID		-NhBUtNva9atciO_OXgH	active	\N	2023-10-20 09:51:51	2023-11-14 08:26:19	\N	\N	\N	Business Bay	653a4fb009f5d_1698320304.jpg	0	25.18423301	55.25999565	United Arab Emirates	Dubai	6565655	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	12d4d9f3ec83ed7c	\N	\N	\N	normal	0	0	\N	\N	971	000000000	0
129	test	testdriver9@gmail.com	971	3690852147	1	$2y$10$OMdO2d/Nny5//3/hEE2tGuKoqz7a1ccrd9Hl/mQyvk91v1e5OlO2e	\N	2		fN8dxgteT9iH3U7n5ecduz:APA91bHoGPJUEOz3kGytuRN95rmRsc8mYRa0-O9bPw8JWK4-2wavA7pgcvAssA1CamIM43HTWx29_0HHI3RNjZXeu_VI5_GKKF8EnibgYFw-tcNyzi-qTdja4gllaeX8hGbjliZhH8AZ	ANDROID	545|glK2iXrbbbLDotDyRwfBhHH1nHz2XhctNvNeWtkN	-NiurTYQXuH6K9hsUX_i	active	\N	2023-11-10 20:13:06	2023-11-14 01:30:27	\N	\N	\N	Business Bay	\N	0	33.51644025228788	73.11081446707249	United Arab Emirates	Dubai	\N	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	7db5d4dbe030f9f9	\N	\N	\N	normal	0	0	\N	\N			0
137	Dxb cargo	anil@dxbusinessgroup.com	+971	46466494664	1	$2y$10$hVFD2mwPxB04WGRc5JoS3e6D.OFRNZAuJNm/l265jICgutntreWCi	\N	3		deviceToken	ANDROID	490|Qnle48mlXxvagpG7Cyo3bcJlqJsW4s4zxHlVqriT	-Nj2HFOg03UNZeBMfhsp	active	\N	2023-11-12 15:27:04	2023-11-12 11:36:29	\N	\N	\N		6550b8284b8e6_1699788840.jpg	0	25.298662820568534	55.37878766655922	\N	\N	1	79XH+HM2 Orchid Tower - Al Nahda St - Al Nahda - Al Qadisiya - Sharjah - United Arab Emirates,	3764434	\N	\N	\N	normal	1	0	6373g83be8	6550b809a9cf9_1699788809.jpg	\N	\N	0
123	rusvink	rusvinmerak1@gmail.com	91	7034526953	1	$2y$10$s28YuyyALJwkgs8S0h4VauEQVo9l3mlTO0/.3W8TODk3qtODQOxaa	2023-11-10 09:11:44	3		\N	\N	436|B9aPA7gYhfZdHKeaNOODUEZZSkTOVLTSHCi5h9Sl	-NisV5Og96w5-ka3Bj8M	active	\N	2023-11-10 13:11:44	2023-11-10 13:31:53	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N			0
1	Admin	admin@admin.com	971	112233445566778899	0	$2y$10$dfUFAya4cfLximJGu5GzV.rudOOxZLZus0hxX0hQKV.h2ZRWUxMVa	\N	1	\N	\N	\N	\N		inactive	\N	2023-07-25 19:46:45	2023-07-25 19:46:45	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
38	Garner Gilbert Traders	vyxecexug@mailinator.com	250	446 8857507	1	$2y$10$3h8GMiXxCzk0X3sLTWG9memxvxaoPHCe6BqEQsU8KVTimZKKF/y0O	2023-08-08 09:51:15	4	\N	\N	\N	\N		active	\N	2023-08-08 09:51:15	2023-08-08 09:51:15	\N	\N	\N	4FGX+9X Al Aweer - Dubai - United Arab Emirates	\N	0	25.180615944098218	55.574035817178945	United Arab Emirates	Dubai	10410	Ea id assumenda qui	\N	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
42	Abdul Ghani	seftware.testing154@gmail.com	92	03142919267	0	$2y$10$fBRMht16wKAw.wCRd7q.NO3lqPp63LOogeirXSTJYiGdyXrIixsgK	2023-08-09 12:24:11	3	1111	17737373	android	19|j2jJmTnFyNPLwc0IsTIw2JdYibo3uohQ7LEgxt6o		inactive	\N	2023-08-09 12:24:11	2023-08-09 16:24:11	\N	\N	\N		\N	0			United Arab Emirates	Dubai	00000	ABC, DEF DUBAI	18272727	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
115	ghani 33	ghaniabro33@gmail.com	\N	\N	0	$2y$10$flLkfiZTNsNxBjNzOPr78OSQxnpjMrGPijr/jGWZSh9b0Q6zrNTRC	2023-10-27 10:35:03	3	\N	\N	\N	403|xtu9z8b6ewOgd5aDRmgapBAncuO0o3ZuYPvHQPSu	-NhkguX-__pzGdLXi_fm	inactive	\N	2023-10-27 14:35:03	2023-10-27 14:35:04	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
124	rusvink	rusvinmerak2@gmail.com	\N	\N	0	$2y$10$ZdNIwkB3hOCYTFnmaNwK6eKYL9UovbzprM8.7ks9N95Rn4ivYSZVu	2023-11-10 09:31:25	3	\N	\N	\N	434|kPx9bSUh2IE9DYFXYoYo5hws8p7CJLOCQFX5BEnR	-NisZaoLZv6DT5TqHkqL	inactive	\N	2023-11-10 13:31:25	2023-11-10 13:31:25	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N	\N	\N	0
133	karan@&&--------66766665&&&5&&&&&&&&&&&&&&&&&555&-5&&5&&----6666-----6---	karanjaiswl@gmail.com	+91	8920524739	1	$2y$10$4uAwaIKWFxbSff7FoaVFouJn8BMl0Urb/3LlYWzO96Sf02RODV71i	\N	3			ANDROID		-NizNPKXeDOO5a5QYQix	active	\N	2023-11-11 21:15:29	2023-11-13 12:59:05	\N	\N	\N		6551d6ea38a4d_1699862250.jpg	0	24.46457257947072	54.38792333006859	\N	\N	1	Level 4, Al Mamoura Building B - Al Nahyan - E25 - Abu Dhabi - United Arab Emirates,	3764434	\N	\N	\N	normal	1	0	₹_-@**"'.         @&-()?:;*:";∆§÷π©°©©©	6551e23f98edb_1699865151.jpg	\N	\N	0
138	test test	testingfordxb@gmail.com	\N	\N	0	$2y$10$.l5vSTsEtRj9R6bbO2fk7epG.rZ84KWNYxdOwZg6Dredf2g9b4Ui2	2023-11-13 05:25:32	3	\N	\N	\N	494|FyEJdTlZSOimLKsx5YyM7rLr0v4kDaeDLz38TzmT	-Nj685MttsYdGsR7Fh5T	inactive	\N	2023-11-13 09:25:32	2023-11-13 09:25:33	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N	\N	\N	0
130	test	testdriver10@gmail.com	971	321258096	0	$2y$10$RihQpXB2.5DjdnCuFb..3.oW3PmMSw8iQ3ePCmYQqQvv3MgPtOrPm	\N	2	1111	dJ7XGG1xRzWaGi-3LvT-oc:APA91bGwG9wVK96aX7lKYEq2xgtSjCmRUWrWy6wRLdPtn37N3bbs_T445Cne4lC-wVpNWPEq4cTz5KebkSDHhteRJg9hbnUA2HDmzOvMLlWDPDbhs38Xe32usqIaxogAK6E-n7j6RA7G	ANDROID	544|Yx4wjAD4mlSWsYw3hjmAVIDpHhQatU6lI71dtQGv	-Nius1HV1XrTdffd_rog	active	\N	2023-11-10 20:15:33	2023-11-14 00:53:18	\N	\N	\N	Business Bay	\N	0	33.51644109087458	73.11082251369953	United Arab Emirates	Dubai	\N	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	7db5d4dbe030f9f9	\N	\N	\N	normal	0	0	\N	\N	971	321258097	0
141	Karan	karanjaiswa@gmail.com	+971	892052473	1	$2y$10$pc4xJHpLCGLwkM24aYAwUucwuBFUHXE18q7FOGfDq/DDCrY3RBDlu	\N	3			ANDROID		-Nj7lPvQCOk3weSP_FN_	active	\N	2023-11-13 17:01:20	2023-11-13 13:35:12	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
146	Testt	karanjai@gmail.com	+971	8424554646	1	$2y$10$5.UnpzFGVPcvHx9HP9voiOMvvMjlooGaNB5ed9jzx6qzrw7ph4Nxi	\N	3		deviceToken	ANDROID	558|uhDLdGRNRNotJNyfGIGKsF1M6UogErq6YptPFuem	-NjC4YZABB5awcuOGwpJ	active	\N	2023-11-14 13:07:47	2023-11-14 13:07:47	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
41	Abdul Ghani	seftware.testing1555@gmail.com	92	03368353584	0	$2y$10$BWdrP5.fBQ99SALZrmng3OtKG3qimiF6HPHXpxXvNMzPv929y42lO	2023-08-09 12:14:01	3	1111	1773737335	android	18|5h2Dh5uWRwdYD64Chm6xZvE1bXs9zFITw23EJVaP		inactive	\N	2023-08-09 12:14:01	2023-08-09 16:14:01	\N	\N	\N		\N	0			United Arab Emirates	Dubai	00000	ABC, DEF DUBAI	1827272775	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
43	android test	android_test01@gmail.com	92	03001234567	1	$2y$10$tOEXh7NxC.0TPugkbRRRUOHJyIxf7g0AQzVeRRwF1HS1kid.dNP6i	2023-08-10 17:14:35	3		17737373	android	21|vGxLZWnX2oUKO7iAuoQP4V2FONVQxO7TeZhbrt7J		active	\N	2023-08-10 17:14:35	2023-08-10 21:16:41	\N	\N	\N		\N	0			United Arab Emirates	Dubai	00000	ABC, DEF DUBAI	18272727	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
45	company test	android_test2@gmail.com	+971	030098765432	1	$2y$10$cVnBUXbbV8SG68qWFiEuRecX.6.O4Owj51x2jzVtQe6Ce4SBxm7Cy	2023-08-12 06:46:45	3		deviceToken	ANDROID	28|1kC9OHghL1V0ppQhgAXQqGVVCZuscXWbxr2wHRuE		active	\N	2023-08-12 06:46:45	2023-08-12 10:47:22	\N	\N	\N		\N	0			United Arab Emirates	Dubai	1	ABC DEF	3764434	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
48	Abdul Ghani	seftware.testing11115@gmail.com	971	3383838400	0	$2y$10$eCG6yxZlHXcxzIWETo9SKOYuEHg7aEH9yWNycrYDzPcY8iSQW7rPi	\N	2	1111	882828282	android	901189625be49b7081b3e7b070b8c43b576b3c1bbbc6f75bfcab30c1d2681c9d		inactive	\N	2023-08-17 18:06:04	2023-08-17 22:13:04	\N	\N	\N	Business Bay	\N	0	25.15285477	55.27328796	United Arab Emirates	Dubai	\N	ABC, DEF	12122112	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
116	ghani 33	ghaniabro34@gmail.com	\N	\N	0	$2y$10$0xtZ8Nz4e3aqUmFNPPt8uO6NiSnuNbYMMFe6sT28RQgA1p1d1MhA.	2023-10-27 10:35:58	3	\N	\N	\N	404|2pG47eomWu9n7GsTVLHS4FDto8ghM35Rc8MUgzDd	-Nhkh6z46ceZOw3Qev9-	inactive	\N	2023-10-27 14:35:58	2023-10-27 14:35:59	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
139	NbDriver	nbd1@mailinator.com	971	984569999	1	$2y$10$oDq.uxyfu37ZPRZrn4T7q.5ZOK6YARyuDzMl7ExIFBwlzzCmW9Ohy	\N	2		dcDV9RDLRQCtfobPdO6K1-:APA91bF9bKTdOYCxFgoRujStVmPHh_zX2DEcW7Kn42CQdj6FmYPbrsrSlkLc0qiTmLufnXlazBZNzKPBC4yV800tWANfxEJ3U4UOhOwwJVuYFERJ_cIIDKMEvMDOQPIhHH_jWOyIm0be	ANDROID	548|oRLRDidWneGuLqKaO3KiUoaRJy2i4fLAYrSfxd6t	-Nj6DMJGaMjUORVpaJ6t	active	\N	2023-11-13 05:48:33	2023-11-14 09:51:08	\N	\N	\N	Business Bay	\N	0	22.4898608024688	88.37032970041037	United Arab Emirates	Dubai	\N	38, Ananda Pally, Jadavpur, Kolkata, West Bengal 700092, India,	350910f03cd8ff92	\N	\N	\N	normal	0	0	\N	\N			0
125	rusvink	rusvinmerak123@gmail.com	\N	\N	0	$2y$10$lVSsHqZmNqIZ2JKihJo5wuO7HkB8i8rkhToY5i/mdd3N4VLiQoOMe	2023-11-10 09:32:08	3	\N	\N	\N	438|qK0uZNuJjbueh1p3Wck9PObSsbyFRZZXqkeiuUhq	-NisZlOPaGA5kmlTP6dK	inactive	\N	2023-11-10 13:32:08	2023-11-10 13:32:09	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N	\N	\N	0
134	DX App	appdx0911@gmail.com	971	996666966	1	$2y$10$5iGDcXDin/4omJInqQ6eM.hNclNXG5GnrR/PexnrJm0t8/p3m4TEa	2023-11-11 17:32:12	3			\N	495|xfo9wCEaWCsFSteKwPYolrxep0W5zWqPtjZM8DNK	-NizREBL5Q1EB_3Ore3m	active	\N	2023-11-11 21:32:12	2023-11-13 09:30:12	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N			0
142	test	karanjais6@gmail.com	+971	000000000	1	$2y$10$Xxw8lQazdZqT8v1sjiHqieKUysB4qjmkkZ40d3gD6voVroIvgzRL2	\N	3		ekJA8MeVRWWtJeTP63Hu6V:APA91bFxMmibLQUtjGuN8powXw-aq117lS9u3rrBDTRtFGuZkqAe6h_5qVCSKdGxu_fl_F6CWiEtVrRfEft2yHf235joM10R0FbrFwWghBcIQjxXxK2-oj_aH3Ru4KvyVZ21Yf40znYu	ANDROID	552|WKTmrH5iMBz74hu1wOwrKWtC7pUEUPjpaIkGAAm1	-Nj84lDADlBAnHfazMXP	active	\N	2023-11-13 18:30:14	2023-11-14 12:44:32	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
131	karan jaiswal	karanjaiswal@gmail.com	44	**********	1	$2y$10$jj8wTIPMzYLnmi7hy2cDse66JCmEPDQXVIsheJ9lXmfUXx/0wVdaS	2023-11-13 18:18:15	5	\N	\N	\N	\N	\N	active	\N	2023-11-11 13:26:30	2023-11-13 18:22:36	\N	\N	\N	P6FW+F6C, Pusta Number 2, Sonia Vihar, New Delhi, Delhi, 110094, India	\N	1	28.7235831	77.2453425	\N	\N	\N	\N	\N	\N	1111	2023-11-13 12:59:45	normal	0	0	\N	\N	\N	\N	0
39	Abdul Ghani	seftware.testing15@gmail.com	92	03142919268	0	$2y$10$EouBszskiyGsJFsswTD/0uO1XIowXm42a3DnxE9muiKXwFAssIUDa	2023-08-09 12:08:05	3	1111	17737373	android	16|UAQUrbvaSiea6oh36XHAWrabnGScMzc6B2PtkeYG		inactive	\N	2023-08-09 12:08:05	2023-08-09 16:08:06	\N	\N	\N		\N	0			United Arab Emirates	Dubai	00000	ABC, DEF DUBAI	18272727	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
47	Abdul Ghani	seftware.testing1115@gmail.com	971	338383831	0	$2y$10$CCcHOHUBQFpZeHrEODuuO.WOhOw9I2dgfggke3oWHjQL9nGALZnMi	\N	2	1111	882828282	android	93df40f418ab81d45678dcf7a0912fba3bd05d523f3e598f2c845a69bf2e76d1		inactive	\N	2023-08-17 14:50:05	2023-08-17 18:50:05	\N	\N	\N	Business Bay	\N	0	25.15285477	55.27328796	United Arab Emirates	Dubai	\N	ABC, DEF	12122112	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
50	Abdul Ghani	seftware.testing090@gmail.com	92	3094172405	0	$2y$10$YZvr2bPBieI0ijcF/UHAfuLKh1Oikh2be5WY/iwx8J.KDUWoUwCEu	\N	2	1111	882828282	android	27ceea1ce3f576923dc45aaa8957ee05a9a25e1fa7dbb3fa487e946fad79812d		inactive	\N	2023-08-17 19:46:58	2023-08-17 23:46:58	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	12122112	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
40	Abdul Ghani	seftware.testing155@gmail.com	92	03142919269	0	$2y$10$FDvHU9M91PhPE7xoG/DRKuEnWqKjZLo0O5rhnOq1XT5Di00zY7/RG	2023-08-09 12:12:57	3	1111	177373733	android	17|Doe3Jh6PfXQI6hDxR1JkwerBEF0hsAe5XbwXfwYM		inactive	\N	2023-08-09 12:12:57	2023-08-09 16:12:58	\N	\N	\N		\N	0			United Arab Emirates	Dubai	00000	ABC, DEF DUBAI	182727277	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
51	Muzammal	faridmuzammal75@gmail.com	92	3317958427	0	$2y$10$STHtEc6.XOyM1DS1OQW4WOKYcXcrXZHjhlwaTD2BOXhG7DIxf3Oa6	\N	2	1111	access_token	ANDROID	3c2ed1300493d28f01f9fe1ae517f83ba707587a0b053c6931eca8e62b67f045		inactive	\N	2023-08-17 21:02:22	2023-09-09 21:29:29	\N	\N	\N	Business Bay	\N	0	31.55581769	74.27936409	United Arab Emirates	Dubai	\N	H74H+9P2, Captain Jamal Rd, Sanda Lahore, Punjab 54000, Pakistan,	0c4144052565a266	\N	0	2023-09-09 17:29:07	normal	0	0	\N	\N	\N	\N	0
37	Abdul Ghani	ghaniabro11@gmail.com	92	3142919268	1	$2y$10$JErk2i3TAp1NphNohP.atuXJl.pacgGQotEHgDODG1XUXcE6XrFeK	\N	2		882828282	android	78|pumn6kXlYuzv3Pc9cHGsfRYW9ibxXn3XPdeLp1WB		active	\N	2023-08-04 20:32:36	2023-08-21 09:33:41	\N	\N	\N	\N	\N	0	\N	\N	United Arab Emirates	Dubai	9877	Street 02 Northern Creek	12122112	\N	1111	2023-08-21 05:33:41	normal	0	0	\N	\N	\N	\N	0
49	Abdul Ghani	seftware.testing00@gmail.com	92	3094172404	0	$2y$10$JRhem14.C7Um36sxvqW/VeNqmCPUdnUa3FSDLsTW/SfmHr1oBkbsS	\N	2	1111	882828282	android	da2eabf2707fd86f541d770519159d6113e97937918f43480a70f83e8ba65166		inactive	\N	2023-08-17 19:33:04	2023-08-17 23:33:04	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	12122112	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
46	Abdul Ghani	seftware.testing15555@gmail.com	92	033683535845	0	$2y$10$KHz7b54NHRxC6KRDf6XmIeMyBy1jo9xMAsR.sfYzQo/6Ibo29AjuO	2023-08-12 10:51:10	3	1111	17737373355	android	29|vGwTyWBcDf9gICEOeQvrRfqtf0ZbPGTA19YwdXYj		inactive	\N	2023-08-12 10:51:10	2023-08-12 14:51:10	\N	\N	\N		\N	0			United Arab Emirates	Dubai	00000	ABC, DEF DUBAI	18272727755	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
44	Android Test2	android_test1@gmail.com	92	030012345678	1	$2y$10$x8N2obZrqOsTVyg3Lg8rzeEaKTRxsDZ23NJopH5NPrlVkmnGJn4Em	2023-08-12 05:15:57	3	1111		android	96|rb2l6zxYqlCfL8NKOIqZjvol6AeC20ourgQcGuYT		active	\N	2023-08-12 05:15:57	2023-09-04 22:03:57	\N	\N	\N		\N	0			United Arab Emirates	Dubai	00000	ABC, DEF DUBAI	18272727	\N	0	2023-08-19 13:06:47	normal	0	0	\N	\N	\N	\N	0
52	Muzammal	faridmuzammal751@gmail.com	27	3317958430	0	$2y$10$xDTIkSreokXkHdQzRB2qVu/vJQqvfV8AkqIqU5/L13XGrtfUH5246	\N	2	1111	access_token	ANDROID	ecc00382cff5a309a956941191ea916838d7a72ddbb5edc204dfbd029c4afcc7		inactive	\N	2023-08-17 21:44:02	2023-08-18 01:44:03	\N	\N	\N	Business Bay	\N	0	31.55581340	74.27936476	United Arab Emirates	Dubai	\N	H74H+9P2, Captain Jamal Rd, Sanda Lahore, Punjab 54000, Pakistan,	0c4144052565a266	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
61	Muzammal	faridmuzammaluu75@gmail.com	92	3317958333	1	$2y$10$arFGOaZdVWmHYMp7dmBJB.CmrRdQ8w3RgJkacsFXcOCyHXQmnNEje	\N	2		access_token	ANDROID	826b01f125474cca2993d2bd7e21b30f1a4d11b8229c86ebaec0f6105281f992		active	\N	2023-08-18 11:11:29	2023-08-18 11:11:40	\N	\N	\N	Business Bay	\N	0	31.55581283	74.27936342	United Arab Emirates	Dubai	\N	H74H+9P2, Captain Jamal Rd, Sanda Lahore, Punjab 54000, Pakistan,	0c4144052565a266	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
57	timerx	timerx01@gmail.com	+971	3441568887	1	$2y$10$lOfUBid68m/BGpGirPVAM.CJNIztbz9oqaFYeLvSmRGhs/uGhYhsq	2023-08-18 05:09:12	3		deviceToken	ANDROID	58|nKcQOxuGXHGwMLSQ9B1H4PXtDIuS51zcr8oGtixI		active	\N	2023-08-18 05:09:12	2023-08-18 09:32:55	\N	\N	\N		\N	0			United Arab Emirates	Dubai	1	ABC DEF	3764434	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
53	Hamid	razahamid34@gmail.com	+971	3441562554	0	$2y$10$0gBL0kONigZYbTOa.xOBg.hsuMvrL5A3uPLiv15Bh7mPKCovVlTui	2023-08-18 04:28:14	3	1111	deviceToken	ANDROID	53|07N7Xu9xg7Jh7W5Y41vLJmiFTs3aaNcQFZXGHiNB		inactive	\N	2023-08-18 04:28:14	2023-08-18 08:28:14	\N	\N	\N		\N	0			United Arab Emirates	Dubai	1	ABC DEF	3764434	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
54	Hamid Iqbal	razahamid37@gmail.com	+971	3664545454	0	$2y$10$3XDHryCVF.K7U96Jz2JDU.0EqfnU/d0CrUC1KLA2Z0CueE/natY9i	2023-08-18 04:29:29	3	1111	deviceToken	ANDROID	54|3oWpqUwaLCcrYDl4ai3VFqW5vDtY3eduA0IqtSXW		inactive	\N	2023-08-18 04:29:29	2023-08-18 08:29:29	\N	\N	\N		\N	0			United Arab Emirates	Dubai	1	ABC DEF	3764434	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
65	Muzammal Farid	faridmuzammal175@gmail.com	92	3317087908	1	$2y$10$9eLenb4YI0JEeZALdWPqguxtBkFYLiR2a5cNkSdtzjICr4nFxc4o.	\N	2		access_token	ANDROID	81|zTpXJ5dxv2DNEOAowq5kBKhANKiL4mlgtNCaYqLU		active	\N	2023-08-19 19:19:36	2023-08-21 14:51:15	\N	\N	\N	Business Bay	\N	0	31.55581540	74.27937347	United Arab Emirates	Dubai	\N	H74H+9P2, Captain Jamal Rd, Sanda Lahore, Punjab 54000, Pakistan,	0c4144052565a266	\N	0	2023-08-21 10:50:49	normal	0	0	\N	\N	\N	\N	0
63	Android dxb	android_test6@gmail.com	+971	3009633577	1	$2y$10$4lYJTkAesmjP0dSoCeK1iO9JsKU5f/X6FfofTD1/4NckG0ItC6PYW	2023-08-18 11:55:13	3			ANDROID			active	\N	2023-08-18 11:55:13	2023-08-19 12:26:47	\N	\N	\N		\N	0			United Arab Emirates	Dubai	1	ABC DEF	3764434	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
55	Hamid Iqbal	razahamid39@gmail.com	+971	346464694	0	$2y$10$R0nmwS7xFTVP.frDxF047efJlw0tdJCglQAy5fl8oNNNhOWPrvXNq	2023-08-18 04:30:31	3	1111	deviceToken	ANDROID	55|FTE4l9sYHncORC9M5DrwjJRZHvS4O3xb3vPVgmCQ		inactive	\N	2023-08-18 04:30:31	2023-08-18 08:30:32	\N	\N	\N		\N	0			United Arab Emirates	Dubai	1	ABC DEF	3764434	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
62	Android dxb	android_test4@gmail.com	+971	3008521476	0	$2y$10$RWzXvLNYNM2O1GN1Sqc8uu9gvzMPjP7aE1uN5YdLUl7M045LPztL.	2023-08-18 11:53:35	3	1111	deviceToken	ANDROID	73|nVBgELS4jncmnPQGizmPOjdoLLlcGU0w0IohsdZT		inactive	\N	2023-08-18 11:53:35	2023-08-18 15:53:36	\N	\N	\N		\N	0			United Arab Emirates	Dubai	1	ABC DEF	3764434	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
60	android dxb	android_test3@gmail.com	+971	3007412586	1	$2y$10$o9vFgnXZWNziqzj1TSfEkuQS8hLwUTKDJbqTunyrJuoN.BUMKwHq6	2023-08-18 10:39:42	3			ANDROID			active	\N	2023-08-18 10:39:42	2023-08-18 10:44:44	\N	\N	\N		\N	0			United Arab Emirates	Dubai	1	ABC DEF	3764434	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
56	Hamid Iqbal	razahamid40@gmail.com	+971	346464664	1	$2y$10$SbEzyvQslSgSMAnCrPxak.5VpbckKEdO.C/FzSixIwfl02No6k6KG	2023-08-18 04:34:23	3		deviceToken	ANDROID	56|cy1SnbevjjG2KwGLre4g8qEKjlAh1Ch0Z3vuKHcI		active	\N	2023-08-18 04:34:23	2023-08-18 04:34:38	\N	\N	\N		\N	0			United Arab Emirates	Dubai	1	ABC DEF	3764434	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
59	Devika	devikasr1995@gmail.com	27	502693489	1	$2y$10$0o/yCsMYt6Tf/W.wcsLY6O.LifbOVDaHYLq5mh2KbVCMOaQVII3rK	\N	2		access_token	ANDROID	66|dOoifrQYLxLONttdr0m8QLSR8M0q9eq7SMiXdIFh		active	\N	2023-08-18 09:02:22	2023-08-18 13:10:57	\N	\N	\N	Business Bay	\N	0	25.00001951	55.02600309	United Arab Emirates	Dubai	\N	Mina Jebel Ali - Dubai - United Arab Emirates,	ff0754b079f2853d	\N	1111	2023-08-18 09:10:57	normal	0	0	\N	\N	\N	\N	0
66	muzammal Farid	farid@gmail.com	92	6317958427	1	$2y$10$txnAsyW9LkoLL466fA3LAOi9TN67BF.qxBY7vLq/pVfS66zwXd4Se	\N	2			ANDROID	86|D0h5aH1rZnb31IF97ujVdkggkOxnPsVIGNIG4A2S		active	\N	2023-08-19 22:28:54	2023-08-21 16:21:09	\N	\N	\N	Business Bay	\N	0	31.55581283	74.27936912	United Arab Emirates	Dubai	\N	H74H+9P2, Captain Jamal Rd, Sanda Lahore, Punjab 54000, Pakistan,	0c4144052565a266	\N	0	2023-08-21 10:45:18	normal	0	0	\N	\N	\N	\N	0
64	Muzammal	faridmuzammal7y5@gmail.com	27	3317958147	1	$2y$10$JR4BsVcvrma.QdzWon/46OvmlmCFJ9cwVBs4HNFVLkW7tumEoVvhu	\N	2		access_token	ANDROID	311b50a08db9a87cccff984462ec0878e154fb16f8833c0bcb01a805e85fbd4f		active	\N	2023-08-18 15:38:18	2023-08-19 19:14:42	\N	\N	\N	Business Bay	\N	0	31.55588283	74.27935436	United Arab Emirates	Dubai	\N	H74H+9P2, Captain Jamal Rd, Sanda Lahore, Punjab 54000, Pakistan,	0c4144052565a266	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
58	Muzammal	pyxiscoding@gmail.com	92	3317958567	1	$2y$10$sW5q6bDp12H/bKosckKmBuLXH77xUVovSppiAyoUC9jLyLnsUUaXe	\N	2		access_token	ANDROID	64|XZQKlY6RLdJpymADBhSlVF3eFZM1D7ZyqB9eFJzx		active	\N	2023-08-18 08:27:50	2023-08-19 23:15:13	\N	\N	\N	Business Bay	\N	0	31.55581883	74.27937079	United Arab Emirates	Dubai	\N	H74H+9P2, Captain Jamal Rd, Sanda Lahore, Punjab 54000, Pakistan,	0c4144052565a266	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
67	Android Test5	android.testing5@gmail.com	92	03001111111	1	$2y$10$1ZBZBbaCbHuJR5BGWYN.8.OBpbgqRwJTahnFofLhXawiW.RF1dfh2	2023-08-21 16:33:41	3		17737373	android	88|lsu5f8jB7Cc51tnkWkAgdDo98InRaiYAhM13yljx		active	\N	2023-08-21 16:33:41	2023-08-21 20:34:40	\N	\N	\N		\N	0			United Arab Emirates	Dubai	00000	ABC, DEF DUBAI	18272727	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
68	Abdul Rahman khan	abdul@gmail.com	27	333777999	1	$2y$10$tZUQqbE1aD0yWlCcoeHVWuSGANfucud80MuwMXjN3TEp9vK7M9r1K	\N	2		asd	ANDROID	7d168cb1e15794077f9f29bd5a3d48fda2a09a6b144784acf71a0f5fb135658b		active	\N	2023-08-31 20:18:04	2023-08-31 20:18:16	\N	\N	\N	Business Bay	\N	0	31.55581426	74.27938286	United Arab Emirates	Dubai	\N	H74H+9P2, Captain Jamal Rd, Sanda Lahore, Punjab 54000, Pakistan,	0c4144052565a266	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
69	test driver	test_driver1@gmail.com	971	456321789	1	$2y$10$61q8R/tHiNmQNQIzAvk3lOVR2C88kPWGJV6IcUbrhHDPQKqV1H9Ay	\N	2		asd	ANDROID	ac81b68ca99f64df4491e585aef873dfa52b636fd13f55e1b5ec6d12982de954		active	\N	2023-09-02 05:04:44	2023-09-02 05:04:57	\N	\N	\N	Business Bay	\N	0	32.07691734	73.67632806	United Arab Emirates	Dubai	\N	3MGG+QRC, Kolo Tarar Rd, Hafizabad, Punjab, Pakistan,	20a11c1f86eca55f	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
72	Binsha Mb	deepika@gmail.com	92	6565656556	1	$2y$10$psy6PfrjTfPtfrcL.IqQD.xQk04IoAel6M8Yhdy0bwFUFBQaAhx9.	\N	3		17737373	android	99|cDjpTcThSHcQ2dkAyxiwRxf6GXLyvqj2Jvu0Q5Do		active	\N	2023-10-07 08:36:09	2023-10-07 08:36:10	\N	\N	\N		\N	0	\N	\N	\N	\N	54364654	ABC, DEF DUBAI	18272727	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
76	tesDev	test@gmail.con	+971	0900786012	1	$2y$10$46CghADdxWXNgEq/sVP4e.qnUQVqvzRgzkiEeme5RsFQ1rU.HcxYC	\N	3		deviceToken	ANDROID	116|8M9aYRkMIXkDMPBsrggawxoM4s8vh3gfBrY8FII7		active	\N	2023-10-09 08:51:03	2023-10-09 08:51:03	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
70	DX	dx@yopmail.com	+971	5248866658	1	$2y$10$fr.KE80ZSZ/DXdlpHj5vNeuoOAB7snrBIcpkePCzvwQPuwMnokgjS	2023-09-04 07:56:08	3			ANDROID			active	\N	2023-09-04 07:56:08	2023-09-05 05:27:01	\N	\N	\N		\N	0			United Arab Emirates	Dubai	1	ABC DEF	3764434	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
79	FRP	fep@yopmail.com	+971	5428486767	1	$2y$10$/OlGPr2blsPohDI/qqYlHeh1q.KaB/Wandwect6UoWnuwpm3xK1EO	\N	3		deviceToken	ANDROID	130|tnnKi8oIYKAF5WkDbKKVW2HeYvTav6dvwuFE5e8X		active	\N	2023-10-09 17:08:05	2023-10-09 17:08:06	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
75	Mahima Cherian	mahima@dxbusinessgroup.com	+971	55424884664	1	$2y$10$VLK.FMOa3dO1NTAaXLaGLe8/6xQuLQlMfH8ygWMBLbKDvUFFOklJO	2023-10-07 10:07:53	3			ANDROID			active	\N	2023-10-07 10:07:53	2023-10-07 13:56:23	\N	\N	\N		\N	0			United Arab Emirates	Dubai	1	ABC DEF	3764434	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
78	Perls	perls@yopmail.com	+971	554251884	1	$2y$10$0GeAqCeHYNohqIkkw.5hfeD6bsKLMAPzwU1hqBOw/I5onYOjFnXCe	\N	3		deviceToken	ANDROID	131|w9PdwYG8OywE9Q4uem7WmIh0qkuoDp8dd2p1k4Yu		active	\N	2023-10-09 17:06:38	2023-10-09 17:08:25	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
77	testDev two	test2@gmail.com	971	1470852333	0	$2y$10$z2fEBoMYCWGdzdaHvu1n0uk1wlAYJveThto6zG3l6tp.Y3p2vj4TG	\N	3	1111		ANDROID			active	\N	2023-10-09 15:58:48	2023-10-10 10:40:26	\N	\N	\N	Street 02 Northern Creek	652512790e5c6_1696928377.jpg	0	24.828038293264758	55.591169515385324	United Arab Emirates	Dubai	00000	H48P+PP4, Block A Police Foundation, Islamabad, Punjab, Pakistan,	3764434	\N	\N	\N	normal	1	0	090900909090	652512790ce5a_1696928377.jpg	\N	\N	0
80	test three	test3@gmail.com	+971	0987456321	1	$2y$10$Xe2LGZIOAgw0M9XyB/kLe.Y27qaVO3.KB0Z0yqAzqr4aOU04RXOfe	\N	3		deviceToken	ANDROID	143|6c1ciR2iOIY4lG2BIrdtqv88N8JJe9sBPhVzZ3vN		active	\N	2023-10-10 01:32:27	2023-10-10 01:32:28	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
81	test four	test4@gmail.com	+971	1470852147	1	$2y$10$dfmaPHcoSBzMCPU4O9ykoOPwiFqZBNGrz9oXz9X5f90GPlI2biiyG	\N	3		deviceToken	ANDROID	146|XrbeOmpHlmVqQomZAUcX4g3tv3JnKSro4ziA8kcq		active	\N	2023-10-10 01:43:06	2023-10-10 01:43:07	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
82	test five	test5@gmail.com	+971	3211232123	1	$2y$10$SVw9ldTDa4ICRSlgNlavu.UiZSYjs6bZMx.3KZZ9Xes2x/jiCzMKu	\N	3			ANDROID			active	\N	2023-10-10 01:48:31	2023-10-10 13:21:42	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
71	android tester	android_driver12@hotmail.com	27	321456988	1	$2y$10$u9U4BgTzpOKfXhq27L8szuOGXyXq7AUllU4B5tFBn0Kw5EOWfsOp6	\N	2		882828282	android	213|H3BLXYdvrorVmRo73lHGkJxDHTjpOPKAE4tRKSuh	-NgwneJ5hfWATnoiOHNY	active	\N	2023-09-07 07:43:48	2023-10-17 15:11:43	\N	\N	\N	Business Bay	\N	0	31.49363000	74.41718135	United Arab Emirates	Dubai	\N	Divine Mega 2, Ghazi Rd, Gulshan e Ali Colony, Lahore, Punjab, Pakistan,	20a11c1f86eca55f	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
84	D X Technologies	dxbapps@yopmail.com	+971	5515256547	1	$2y$10$cqjbFJUOSZ2/wgjhBd1tuOpdBW/whWUu3tUXXDh2ewyQathBjsxCO	\N	3		e0n5k_nHRZCGtWaMeFf2K_:APA91bFeoXy7TIvZBYSLOpBzhz0rpiGHFpLQ9snYnwBwrA6aiRPf4IstK14hErewairH-6M7hRGo2UPM-Ojij0ebpaMm27fnnwBIvPscIsfd1Uh43uIHcI9ySA8g-S7gd6gUJ6S4hXza	ANDROID	415|fN3Ytd4dCD2qtFHK7Og2DMvdujcT5f5QXeKghYZ6	-Nh0uBy-49vgjB4dmEG_	active	\N	2023-10-18 12:30:57	2023-11-07 10:58:55	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
85	Liverpool	liverpool@yopmail.com	+971	552125893	1	$2y$10$jy8hNgKif7VKTx7LQfrt3e6Orwv9Mv7yWlh/H6dR8YNX8rJyUsujy	\N	3		cqN7S8YxSF6KRWvD6Jh-Ym:APA91bGhaSUGiSrjN6IOZGXX19E0BHvXC-yBKDbXNvd5S7glolHDUEoZgTNvOfW4sTpmANDGThoeXO6LCd-_mS6ayEKXARAiKrzxTmO5xpgr7BRFnAF-7n3V2AeXLWt6sWUcASSulT3N	ANDROID	396|4cRQgh37AKnLxlLKCsX54yHJfj4Q0Q6hzNZsMNL4	-Nh13diJ-tLmx8gmDjOg	active	\N	2023-10-18 13:16:37	2023-10-27 10:15:03	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	0	2023-10-20 11:30:07	normal	1	0	\N	\N	\N	\N	0
74	Glen Max	binshambrs@gmail.com	92	03142919744	1	$2y$10$aCXlFZaWW12WPj6//n/8o.XTDFZnGt40GAxiUipIqLEasmOmXfCIC	\N	3		17737373	android	395|PtTh7AZFPvZ9iZvMZCq98lbubmAGc1xVEGnyCg6f	-NgwERgo-mD4CtGXkkp7	active	\N	2023-10-07 10:17:16	2023-10-27 10:10:37	\N	\N	\N		\N	0	\N	\N	\N	\N	54364654	ABC, DEF DUBAI	18272727	\N	\N	\N	normal	1	0	5435436	6524dd11432a8_1696914705.png	\N	\N	0
117	sf	social@gmail.com	\N	\N	0	$2y$10$QFETcm7DunWYAjkZ9QhDbuR7ABO1uS2nLyMbkhaoW21p/YcO2bZb2	2023-10-27 10:42:05	3	\N	\N	\N	406|pMc8sMrjKKHbs0deP8t0NwfqeGllMCTs1K2liuQt	-NhkiWMU0Cg6JEIZf_Hb	inactive	\N	2023-10-27 14:42:05	2023-10-27 14:42:07	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N	\N	\N	0
135	Nemai Biswas II Software Tester	nemai@dxbusinessgroup.com	\N	\N	0	$2y$10$/VIpvnX0.pgMCtyCh7HgL.MTki5GqVtk2hUsmtkzenijcjj0aFKxu	2023-11-11 17:50:48	3	1111	\N	\N	484|bmyf7VFjAUyqHfqxXTas2pfrHWiD88pwffL5ObZY	-NizVUh2Ac7cl0dASQ6i	inactive	\N	2023-11-11 21:50:48	2023-11-11 21:56:22	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N	971	988789996	0
126	rusvink	rusvik1213@gmail.com	\N	\N	0	$2y$10$uGVfUoOvGTTdc1q/FHAjM.eGk3QU839JYPe8oRmwR/kWh1L8T7tua	2023-11-10 09:35:12	3	\N	\N	\N	491|3E8IDco0NZaXd1uMF4dVk44zcQ2sUvDkr61ishDO	-Nis_TJdehi408Fu4Kti	inactive	\N	2023-11-10 13:35:12	2023-11-13 08:49:42	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N	\N	\N	0
143	test six	hunain66@gmail.com	+971	3214569870	1	$2y$10$68XxFpOT5ouSx7x5lqBHzepVjirpLajFnVuQZx4d5YFw6nOFilTqy	\N	3		fYoS2zgaT_eFwe7iykc6eu:APA91bHePPlIytbjBHUV_OtpWo_szc05Zv54gDzo1TePQSQ--ogr2HLetkY-S5xpwhc7bP4n9xmFbz1WZ77UMOgMaSRK5tVnKjWs2IBKNvGtywz_WAzJfGtRFuENqzHudzMHscbv-qyj	ANDROID	541|5ea1ciumACVY2mIwefyp6GwPrA4eIlYP9xYgyJ3k	-Nj8enfpKhwOG4Fvd6Ch	active	\N	2023-11-13 21:12:03	2023-11-13 23:56:41	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
95	test six	testdriver6@gmail.com	\N	\N	1	$2y$10$c92nyblca5VUA5aMKFr4Eeo8qHGxvESpvFot7XUEV7WqUxDB0FOrW	\N	2		eKZlbTbWTHKyZvserRwK1n:APA91bHGYyhUYfq7ItGvs_BLOxuyN3UM3ZMti0dzeG3FxZERUlWLhtZ_QuYK-iLIytciRThRDh9zGbcLHA27AWvHANQ3FfCpiDXUs_ilNx9j_rgbWr8OKaXPqfZwhGfYRoTOfbND_Q3F	ANDROID	284|Mflmuaq6R1fW31CKlP3fOavJKwNfsG2DH0WGBqhe	-NhAoz3CGFtMXJdtem_W	active	\N	2023-10-20 06:44:22	2023-10-20 06:44:27	\N	\N	\N	Business Bay	\N	0	33.56679110	73.13683055	United Arab Emirates	Dubai	\N	H48P+PP4, Block A Police Foundation, Islamabad, Punjab, Pakistan,	507c25ffbc01d8ae	\N	\N	\N	normal	0	0	\N	\N			0
89	test three	testdriver3@gmail.com	Dial Code	67677777777	1	$2y$10$qWMgILBzagTXso2wY6F9K.ymUEjOzVo4isePZ1Hv1pq2BcwbXxm8u	2023-11-14 11:56:26	2			ANDROID		-Nh82BMLcLSgX8ak8pVM	active	\N	2023-10-19 17:47:35	2023-11-14 08:29:08	\N	\N	\N	Business Bay	\N	0	25.16402115	55.40154118	United Arab Emirates	Dubai	566	Cluster - Dubai - Spain S11 - International City - Spain Cluster - دبي - United Arab Emirates,	7db5d4dbe030f9f9	\N	\N	\N	normal	0	0	\N	\N			0
92	Abdul Ghani	driver@driver.com	\N	\N	1	$2y$10$TH051hfY2r/1E7RjK/hJuuz.tBnVsWnngGDgek57WIKXss7DCkMA.	\N	2		882828282	android	277|BhK31ke2YgOrEG0y1OQ0eMehRrA1b38XsX4qMo4x	-NhAlpCEujfk-4q3gKO8	active	\N	2023-10-20 06:30:35	2023-10-20 06:30:43	\N	\N	\N	Business Bay	\N	0	25.15285477	55.27328796	United Arab Emirates	Dubai	\N	ABC, DEF	12122112	\N	\N	\N	normal	0	0	\N	\N			0
127	rusvink	rusvik213@gmail.com	\N	\N	0	$2y$10$EXvM/L8FHD3hU4QSiKQc2eKbqAH7kzBNAQ0mgt5AYhe1rXvKw6CBS	2023-11-10 09:35:20	3	\N	\N	\N	442|XeD04pC77HcP5uvZoLQmD7nyzMpk5d62SNIDUCBp	-Nis_V5NgQGyTcQ2CiVg	inactive	\N	2023-11-10 13:35:20	2023-11-10 14:36:04	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N	\N	\N	0
91	test four	testdriver4@gmail.com	\N	\N	1	$2y$10$ZseB0oVj8QusuAX/JPJvker.rBjWVwa58OQqFLivgdWuSS.RHmqPO	\N	2		esjXdJpkQHmdpCcOYiZIre:APA91bFhliW1355xxP0KWLICF9mIoN-XMaK8kcbIzc_UE7MkjqUdONHtw6lCUV0NbUo6M--7dD_8p2foULf30TPUPJ_TYH232cEcvMSe5ER8HvrDlmOIE35CvlkNrb-MRdSrs96WmOjP	ANDROID	275|Sozqav8btW2k9AoDxeiwWfYQ8q3LJpyLlUk9Wxdk	-NhAipMhKuqUX-NqHknt	active	\N	2023-10-20 06:17:29	2023-10-20 10:18:48	\N	\N	\N	Business Bay	\N	0	33.56679027	73.13682754	United Arab Emirates	Dubai	\N	H48P+PP4, Block A Police Foundation, Islamabad, Punjab, Pakistan,	507c25ffbc01d8ae	\N	\N	\N	normal	0	0	\N	\N			0
86	kiran	kiran@yopmail.com	971	55224456756	1	$2y$10$sVGpTk.AlEuaBfuilyw4JOpJYp3hnXrtDhxm0LMxDg0Mnf03CmHVC	2023-10-26 15:23:41	2			ANDROID		-Nh1x_sYPt5CSLvry-K7	active	\N	2023-10-18 13:25:23	2023-10-27 07:17:05	\N	\N	\N	Business Bay	\N	0	25.18423453	55.25999364	United Arab Emirates	Dubai	2	Al Manara Tower, 1605, 16th Floor, Business Bay, Post Box 118587 - الخليج التجاري - دبي - United Arab Emirates,	e19e10ee2b97a91c	\N	\N	\N	normal	0	0	\N	\N			0
88	Kishore	kishore@yopmail.com	971	5543979567	1	$2y$10$PBLbkWSUq3bbnpqQys8w2eqt.jj.IzOU2VcRD3CDg.VGjDa.UJzQi	\N	2		flrCMeeASZSY5YdAWEJV2L:APA91bFgqJn77SRInK-wCRBUYTTKeAT2fMLdDflS2CD22Rz5-yvSx6fpxzi1aYmEqN0QM37jNF3Ldjs-TCXY41FFoteLQd61Qsdf3eth3czI3jaMbpkaUrhZMBDY50ZChjUymfP63IKw	ANDROID	378|RdsqKrvJyqtqs9XAqmRp9djdqgr506eE3jLqK7Kx	-Nh63lLiGSdmOHqKIRvd	active	\N	2023-10-19 08:35:14	2023-10-26 17:55:13	\N	\N	\N	Business Bay	6530ea81a45f1_1697704577.jpg	0	25.184244847592886	55.2599785476923	United Arab Emirates	Dubai	\N	3101 Marasi Dr - Business Bay - Dubai - United Arab Emirates,	e19e10ee2b97a91c	\N	\N	\N	normal	0	0	\N	\N			0
87	test Driver Two	testdriver2@gmail.com	\N	\N	1	$2y$10$ziY8ngbcv65RluVPF50YcO.92q4XRCMsYi.rVaVZDqmkFiZCZuGW2	\N	2			ANDROID		-Nh62aECp8xuGVH2M71b	active	\N	2023-10-19 08:30:06	2023-10-19 09:03:08	\N	\N	\N	Business Bay	\N	0	33.56687883	73.13681815	United Arab Emirates	Dubai	\N	H48P+PP4, Block A Police Foundation, Islamabad, Punjab, Pakistan,	507c25ffbc01d8ae	\N	\N	\N	normal	0	0	\N	\N			0
94	yest five	testdriver5@gmail.com	\N	\N	1	$2y$10$Dvo4MrYets/V3av2lzLLCup6CdQggmuXCuDI5dwPft2SWnh0hrfde	\N	2		eKZlbTbWTHKyZvserRwK1n:APA91bHGYyhUYfq7ItGvs_BLOxuyN3UM3ZMti0dzeG3FxZERUlWLhtZ_QuYK-iLIytciRThRDh9zGbcLHA27AWvHANQ3FfCpiDXUs_ilNx9j_rgbWr8OKaXPqfZwhGfYRoTOfbND_Q3F	ANDROID	282|KeBnLJNhyhGbm4Mf8mExAvYKSUaZKhkTDaWpdDfw	-NhAnp99TezVHE2v-6dX	active	\N	2023-10-20 06:39:19	2023-10-20 06:39:30	\N	\N	\N	Business Bay	\N	0	33.56678971	73.13682888	United Arab Emirates	Dubai	\N	H48P+PP4, Block A Police Foundation, Islamabad, Punjab, Pakistan,	507c25ffbc01d8ae	\N	\N	\N	normal	0	0	\N	\N			0
96	test seven	testdriver7@gmail.com	\N	\N	1	$2y$10$JS6ohICxobvqTbDa337u6ulN4AI/rftCZWRoNwbZKBARUv8bcHmw2	\N	2			ANDROID		-NhApzH2WsRye9wXQX6r	active	\N	2023-10-20 06:48:45	2023-10-20 06:49:15	\N	\N	\N	Business Bay	\N	0	33.56679222	73.13683257	United Arab Emirates	Dubai	\N	H48P+PP4, Block A Police Foundation, Islamabad, Punjab, Pakistan,	507c25ffbc01d8ae	\N	\N	\N	normal	0	0	\N	\N			0
93	Meenu	meenu@gmail.com	92	588963258	1	$2y$10$ni8IpYV8SNuY/juztw6.0eTxRzrCtWUPWSEsxU2Q71tP7a28.zQBu	\N	3		17737373	android	280|SPH5Agkd2cYVS97G7YVVvhGu8RQEMyFsqc7V7ZeT	-NhAmTOrQsXvJjeq5r3Z	active	\N	2023-10-20 10:33:24	2023-10-20 10:33:24	\N	\N	\N		\N	0	\N	\N	\N	\N	00000	ABC, DEF DUBAI	18272727	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
118	ghani 33	ghaniabro35@gmail.com	\N	\N	0	$2y$10$k9bNGZgS13ORqx1eq7MGtuDzbSogK6jv61momuwhZtc0wTi8T9xcK	2023-10-27 10:42:38	3	\N	\N	\N	409|lbAtLk50j8IEOZzJsDpg7xjOKv53oCDFKP2L6qnE	-NhkidXdT4fMekW6YS2G	inactive	\N	2023-10-27 14:42:38	2023-10-27 14:42:50	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N	\N	\N	0
90	Abdul Ghani	driver@gmail.com	\N	\N	1	$2y$10$gbA008wC5ksy/UzumWArLO4dVlAu/iB5CSjhGYBICGs1BSBeUvw6u	\N	2		882828282	android	336|4SdzsRlXoEZBYc2BU6zQ10qvqQuklvEgJQM9MDfO	-NhAh897PCGt3cqrF2_1	active	\N	2023-10-20 06:10:06	2023-10-24 12:32:29	\N	\N	\N	Business Bay	\N	0	25.15285477	55.27328796	United Arab Emirates	Dubai	\N	ABC, DEF	12122112	\N	\N	\N	normal	0	0	\N	\N			0
16	Raya Gentry	softcube.web@gmail.com	971	+1 (101) 377-8953	1	$2y$10$qpAqhtSrm66CaSXThpR51uF6ho8VMhFchKFB44zWvR6QIMoAkbvHC	2023-07-26 23:25:43	3	\N	\N	\N	59|MdZnfVQfdSQKteQfBaFYhz3TPhEI84iwffYr6FvD		active	\N	2023-07-26 23:25:43	2023-10-20 15:29:53	\N	\N	\N	HHGJ+RV Al Ajban - Abu Dhabi - United Arab Emirates	\N	0	24.828038293264758	55.591169515385324	United Arab Emirates	Voluptatem quos sap	70689	Laboris in debitis q	\N	\N	1111	2023-10-20 11:29:53	normal	0	0	\N	\N	\N	\N	0
121	more more	testdxbuae@gmail.com	971	36990852321	1	$2y$10$9GykVvXsOC/YeD57hNj6ZuKxFilCgVcme13gb9h8OH0D46IZg.2Ki	2023-11-10 07:14:11	3			\N		-Nis4Bd2G5laqiv7MUIe	active	\N	2023-11-10 11:14:11	2023-11-13 06:02:50	\N	\N	\N	\N	654e755caaffd_1699640668.jpg	0	33.51639245283293	73.11084128916264	\N	\N	\N	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	\N	\N	\N	\N	social	0	0	0986554221	654e754c230aa_1699640652.jpg			0
106	D X	dxbmahidxb@gmail.com	971	564005096	1	$2y$10$qquwSg/daCU.9x9mhZSArefnTNrgfG/Om5wCciBwd7bGOEazPrJRy	2023-10-25 09:48:01	4	\N	\N	\N	\N	\N	active	\N	2023-10-25 09:48:01	2023-10-25 09:48:01	\N	\N	\N	56QV+8RX Tolerance Bridge - Al Safa - Dubai - United Arab Emirates	\N	0	25.187505509882502	55.23908615112305	United Arab Emirates	Dubai	\N	Business Bay	\N	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
101	B test	livedriver@driver.com	971	5787989	0	$2y$10$WW2bEonhw4xFqdJMPzkwCeKIWJUFBnmkj8ka6lAbi6.a4ezGDTKzS	\N	2	1111	882828282	android	303|pOvbmOiQZuXJVps2LE0X8PVrpb2fGUCbfNznEOuY	-NhC7DErCI5qUAjSkjBa	inactive	\N	2023-10-20 12:48:02	2023-10-20 16:48:03	\N	\N	\N	Safa Park - Sheikh Zayed Rd - Al Safa - Dubai - United Arab Emirates	\N	0	25.185434492556674	55.24619407503102	United Arab Emirates	Dubai	\N	ABC, DEF	12122112	\N	\N	\N	normal	0	0	\N	\N	971	5787989	0
98	Driver Two	driver2@yopmail.com	971	576464789	1	$2y$10$2YSJrLuPKZTag1d/f8ejzui9nEI4nQSxIS2HCgYxKam84YUHzmrlC	2023-11-14 12:28:56	2			ANDROID		-NhBVpLmRhGYOGAWk09O	active	\N	2023-10-20 09:55:57	2023-11-14 08:38:00	\N	\N	\N	Business Bay	\N	0	25.19395649	55.23161754	United Arab Emirates	Dubai	16	56VJ+HJQ - Jumeirah - Jumeirah 3 - Dubai - United Arab Emirates,	55a89d5d960c7123	\N	\N	\N	normal	0	0	\N	\N			0
105	Dublin	dublin@gmail.com	+971	3204504501	1	$2y$10$Cz5QGVKEHQnslxzMb5KQXO5eh7jr71cA/x2iJCQjqGGla9140FtlC	\N	3			ANDROID		-NhVajMCT6xgLnOj4clE	active	\N	2023-10-24 11:34:09	2023-10-24 07:45:04	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
100	B test	john@driver.com	971	587456963	1	$2y$10$mG0CdjJPGo5qCvvBUsNt7OEgxGUUGaFaQGknOutJFFNiyI7CK/xmW	\N	2		882828282	android	301|DcwuN9yG4S168Fbg2f4cRjIzdcSSiFEt4pcFZBfE	-NhByq2dJdsUcPqejhy7	active	\N	2023-10-20 12:07:04	2023-10-20 12:07:15	\N	\N	\N	Safa Park - Sheikh Zayed Rd - Al Safa - Dubai - United Arab Emirates	\N	0	25.18543449	55.24619408	United Arab Emirates	Dubai	\N	ABC, DEF	12122112	\N	\N	\N	normal	0	0	\N	\N			0
99	B test	bdriver@driver.com	971	8888888888888	1	$2y$10$QP0WbYduxCx3pWDdTloG8uzTHkTDkdiQ7YWsAvSW.eYRGSQEe7dpO	\N	2		882828282	android	299|T2tV1BKM6pDz12PcqvqOBpF4unLB8sh7QD0dkLX8	-NhBwqxpcdMshlsj88M0	active	\N	2023-10-20 11:58:23	2023-10-20 16:17:46	\N	\N	\N	Business Bay	\N	0	25.15285477	55.27328796	United Arab Emirates	Dubai	\N	ABC, DEF	12122112	\N	\N	\N	normal	0	0	\N	\N			0
102	B test	kiyara@driver.com	971	654756765	1	$2y$10$oySdxva4sVzkxCGV3r.YtuW7tM/SZt6qmFmsrQ4O/WfFw3.vX6MCe	\N	2		882828282	android	305|Ytd6IVrCGj7i0DqZrycF6HlVPZR4E6R1CfC8bx1i	-NhC7o2h0hK_-8vB4JWh	active	\N	2023-10-20 12:50:37	2023-10-20 12:50:49	\N	\N	\N	Safa Park - Sheikh Zayed Rd - Al Safa - Dubai - United Arab Emirates	\N	0	25.185434492556674	55.24619407503102	United Arab Emirates	Dubai	\N	ABC, DEF	12122112	\N	\N	\N	normal	0	0	\N	\N			0
103	hunain dev nine	hunain99@gmail.com	+971	1234567891	1	$2y$10$oEsPd21zL.w57.dKcR5jkuSTlUDHFcpP7TbOCO/1zQEAfeO7ZHRhC	\N	3			ANDROID		-NhFxR8vU2CSqpDSDkhX	active	\N	2023-10-21 10:39:24	2023-11-08 09:16:29	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
73	Hunain De	hunain88@gmail.com	971	090078602	1	$2y$10$5vNUaqZp4V84dnB88rZbZeM8vYkFwiL2OmKN8gdI/OOlANDfSG88i	2023-10-07 05:19:53	3			ANDROID		-NgwBwyQFyOESns4h_Fw	active	\N	2023-10-07 05:19:53	2023-11-14 08:42:36	\N	\N	\N		653b4fde62905_1698385886.jpg	0	33.57005739122855	73.13719768077135	United Arab Emirates	Dubai	1	pwd islamabad، Block C Police Foundation, Rawalpindi, Punjab 44000, Pakistan,	3764434	\N	\N	\N	normal	0	0	0900078603	6531788810613_1697740936.jpg			0
109	RAS	ras@yopmail.com	+971	554228898	1	$2y$10$vS98wsDKwgpAoa9zknaPquziJAqhFU/Zrt7mtp7TH8G0EjdOou8R6	\N	3			ANDROID		-NheQSmA7HrY7EAGrL9x	active	\N	2023-10-26 09:21:06	2023-10-26 11:53:23	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
108	KS	ks@yopmail.com	+971	524158669	1	$2y$10$7rprTTD5n2Rhj10I8E0HTuupfc3eCrFnIv5vSkqrsmWf6GXP3JDg6	\N	3		ctjSPb1yQmGkhexKqeIdQQ:APA91bHIPv2_7yhVKCGjtkqhZXslczZO8bWWmAeTtLlvuRrhgp7WjY-_kKSLd9MkD7M3AUolgnJNtfraIaAo2P66gQgo2b6JNRnQ8s_2b4ZvAMigMksIUY0NJE98sWOvU7tKnUkDrVeC	ANDROID	365|V192YOA0CJC19rQQawByj1qfO1UqGBSJVq24FtI3	-NhamXoIOwXVFVnHJKVS	active	\N	2023-10-25 16:23:27	2023-10-26 10:24:54	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
104	Danish Nisar	daani4900@gmail.com	92	3204504500	1	$2y$10$.AlIrCnQTYIBSCXGt03MN.RUqdETj3BZbwKzupfcaq9k2RzLRUuIa	2023-11-11 14:10:41	2			ANDROID		-NhV_YLoylrBZWuC375x	active	\N	2023-10-24 07:28:58	2023-11-11 10:13:23	\N	\N	\N	Business Bay	6537727486474_1698132596.jpg	0	31.489159443301777	73.09940099716187	United Arab Emirates	Dubai	110111	790 B Block, Millat Town Faisalabad, Punjab, Pakistan,	de53e8cce5a1c32d	\N	1111	2023-10-24 11:19:40	normal	0	0	\N	\N			0
110	GS Company	gs@yopmail.com	+971	5341889666	1	$2y$10$j2vdMLZV3c2EuBZOYi9TEORLZF9L3a5FoN0bOcbYmfdN/ONh4fmxO	\N	3			ANDROID		-NhjXAV1qLOglPFJsgRm	active	\N	2023-10-27 09:08:32	2023-10-27 06:14:53	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
107	Paul	paul@yopmail.com	971	525325917	1	$2y$10$ZSkeGNjvWp3uN32xw.yLz.yhYmLTBBdrlDzDZtg7ps9YiZRKCT0LS	2023-10-25 10:13:12	2	\N		ANDROID		-NhfpjGqFwT-sSDoYPd_	active	\N	2023-10-25 10:13:12	2023-11-07 07:26:38	\N	\N	\N	3101 Marasi Dr - Business Bay - Dubai - United Arab Emirates	\N	0	25.1842002	55.2599217	United Arab Emirates	Dubai	312	\N	\N	\N	\N	\N	normal	0	0	\N	\N	\N	\N	0
119	user One	userone@gmail.com	+971	3204504509	1	$2y$10$RI6HD6dBWQrA7xtcT3/CR.afHDzMKqmUsrx2e3PUgUNG8JlT3oEu.	\N	3			ANDROID		-Nhkm_dB3ThAtzumL_r6	active	\N	2023-10-27 14:59:51	2023-10-27 10:59:56	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
132	karan	kj01@mailinator.com	971	584845545	1	$2y$10$rmW80m.PxvQ8kknOnPStluVFnCpOdwNBclVjSskub1WvA3Wjo.YSm	\N	2			ANDROID		-Nixnqdtt0metAwd2UI0	active	\N	2023-11-11 09:56:08	2023-11-11 10:11:20	\N	\N	\N	Business Bay	\N	0	28.72357747728334	77.24529884755611	United Arab Emirates	Dubai	\N	Abu Dhabi	f8bfa3f90d8388fc	\N	\N	\N	normal	0	0	\N	\N			0
140	hunain seven	hunain77@gmail.com	+971	1236547890	1	$2y$10$lBuTh12fN6gt1.tXk2k6SuqdiZcAsRxhowTvkr6vV9JOZeaPQjg62	\N	3			ANDROID		-Nj6HaduPkhy3PVQjGFg	active	\N	2023-11-13 10:07:04	2023-11-13 17:10:24	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	087532112	\N	\N	\N	0
112	B Z	BZ@driver.com	971	522099155	0	$2y$10$NmcB7j0XhpGaSS1B3f.efOUfjIyTlmKFDJu1cf5bosGjH8MaXr9DK	\N	2	1111	882828282	android	391|yLudaMTzOuHrfDDeLR9Ejv9SsV8agp9KdGZ4ynhj	-NhjcE8yWj9mnGLAOkd8	active	\N	2023-10-27 05:35:00	2023-10-27 10:00:52	\N	\N	\N	Safa Park - Sheikh Zayed Rd - Al Safa - Dubai - United Arab Emirates	\N	0	25.185434492556674	55.24619407503102	United Arab Emirates	Dubai	\N	ABC, DEF	12122112	\N	\N	\N	normal	0	0	\N	\N	971	522099155	0
136	anil	anilnavis@gmail.com	971	946484666664	1	$2y$10$lp0gpDhjCNguWqC2RUy7uumjAeIW3QscFBxbzkJZoeCfH1QK/Ozle	\N	2			ANDROID		-Nj2GLr4BJS82Clr-BAw	active	\N	2023-11-12 11:23:08	2023-11-13 05:01:15	\N	\N	\N	Business Bay	6550b5e96dd68_1699788265.jpg	0	25.287773935101477	55.370356142520905	United Arab Emirates	Dubai	\N	79PC+W2M - Al Nahda - Al Nahda 2 - Dubai - United Arab Emirates,	f74e1ddb2958a178	\N	\N	\N	normal	0	0	\N	\N			0
120	ghani 33	ghanibro33@gmail.com	\N	\N	0	$2y$10$vYmdsQTQeo9glqJDNbUsved528iqoVon6hJKzmpOSg4AzzuksyJi.	2023-10-27 11:01:45	3	\N	\N	\N	414|Nxo6ta16me5DaCQPQGJBignQoTlxj72bIvrRwJTT	-Nhkn0TtmGzC_m2B6ghl	inactive	\N	2023-10-27 15:01:45	2023-10-27 16:21:19	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N	\N	\N	0
113	TSI Company	tsi@yopmail.com	+971	544568266	1	$2y$10$GYit9FipTCPs.tW2ovS5U.a1YjxtFa.RS/8Dcyp1JrVOgCk0BrguK	\N	3		deviceToken	ANDROID	399|nxSIZWYRjfOn8o1WQmTTRUAdpOoWl9AZmTLZFfzn	-Nhjy1YJkUMnTqHI2KrZ	active	\N	2023-10-27 11:10:15	2023-10-27 11:10:16	\N	\N	\N		\N	0	\N	\N	\N	\N	1	ABC DEF	3764434	\N	\N	\N	normal	1	0	\N	\N	\N	\N	0
144	test	testdriver20@gmail.com	971	369082145	0	$2y$10$x99dCe9WfkAeXeSbe5tquONQgDb5q48Hk9yBZ7DyMORlTHQ7VT8tO	\N	2	1111	dJ7XGG1xRzWaGi-3LvT-oc:APA91bGwG9wVK96aX7lKYEq2xgtSjCmRUWrWy6wRLdPtn37N3bbs_T445Cne4lC-wVpNWPEq4cTz5KebkSDHhteRJg9hbnUA2HDmzOvMLlWDPDbhs38Xe32usqIaxogAK6E-n7j6RA7G	ANDROID	543|3x1dMHy12fdFHtpCzkBWO4gjxXg9hFAsO5tC4yaL	-Nj9RS7zZkdlS-GzP-0u	inactive	\N	2023-11-13 20:48:58	2023-11-14 00:48:59	\N	\N	\N	Business Bay	\N	0	33.516402515878255	73.11082284897566	United Arab Emirates	Dubai	\N	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	7db5d4dbe030f9f9	\N	\N	\N	normal	0	0	\N	\N	971	369082145	0
122	rusvin	rusvinmerak@gmail.com	91	7034526952	1	$2y$10$WP0PuXNPosIY0e4Vn5xyl.Zj83yas84bP8bGoGlz7xJK.JoVmMYEC	2023-11-10 09:09:50	3		\N	\N	523|oeK1Zir0aLn5yDTSPu6kzd5Y3OO41PNUIcYgKC9r	-NisUef904BmQvPC6zQC	active	\N	2023-11-10 13:09:50	2023-11-13 16:03:48	\N	\N	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	social	0	0	\N	\N			0
128	test	testdriver8@gmail.com	971	9632508741	0	$2y$10$Veh.80XD7MWx87VReWTZX..TgM1dw9a679FTPoONccxj39gzzofey	\N	2	1111	dwlJyqP_TR2Sdhj2i2WJEZ:APA91bHKYTFhYbjrATGObUKUHZmx7JT3doGYOwphPLIFkpCi0O-hVd2FdOS9TvPmOGfcJDOeLRvFP3tDj-E0wd8Fno9I3f-vClXEmqa-R9OZRGgSQ6TJ6wUkiul8IQDOjvgF8K-lUtb4	ANDROID	467|eoWsIMzPsjsKk4VigfehBIcrvDXm9sUuvyHWrPkD	-NiuqiIaRPxKvm2Fw9MD	inactive	\N	2023-11-10 20:09:49	2023-11-11 00:09:49	\N	\N	\N	Business Bay	\N	0	33.51639217330388	73.11083860695362	United Arab Emirates	Dubai	\N	Bahria Heights 5, Expressway, Islamabad, Rawalpindi, Islamabad Capital Territory, Pakistan,	7db5d4dbe030f9f9	\N	\N	\N	normal	0	0	\N	\N	971	9632508741	0
111	Mathew	mathew@yopmail.com	971	521789966	1	$2y$10$62VfZu7bTA1SzGr.0Puuau1IKoucjyTCLkbxe8SZ98br0InHsgX9C	2023-11-14 12:37:10	2		dk-Ayxm3QF-VyG37zjYczo:APA91bG0SGNNVyr3ndJaN-T-vBbn0JXQzKUGVb88sX33laJneE2Po7w8nMoJFbjoAnh9NrbhyDRK6QLJ74HkhcODzd6C1N5M559uP0Ea77XwGoTjk5UyY88upfAoiY7BhByfBfYwC0DB	ANDROID	551|7kLAbJlqJP7yvRVZsiYG0u7FYYNTWujdnsKJXb8p	-Nhj_jhY6ra7MZ7AwJyv	active	\N	2023-10-27 05:24:07	2023-11-14 12:38:36	\N	\N	\N	Business Bay	653b4d69b8696_1698385257.jpg	0	25.184231497721463	55.259992964565754	United Arab Emirates	Dubai	94	3101 Marasi Dr - Business Bay - Dubai - United Arab Emirates,	272cf02bfddea411	\N	\N	\N	normal	0	0	\N	\N			0
\.


--
-- Data for Name: warehousing_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.warehousing_details (id, booking_id, items_are_stockable, type_of_storage, item, pallet_dimension, weight_per_pallet, total_weight, total_item_cost, created_at, updated_at, no_of_pallets) FROM stdin;
1	109	yes	2	test Apples	9x8x7	3	9	5400	2023-10-20 21:32:36	2023-10-20 21:32:36	3
2	110	yes	2	item fruits	4x1x3	2	16	4500	2023-10-21 09:30:27	2023-10-21 09:30:27	13
3	120	yes	1	Car accesories	160X160	200	2000	12001	2023-10-25 10:31:59	2023-10-25 10:31:59	10
4	132	\N	1	test	1*2*3	10	100	100	2023-10-26 11:25:07	2023-10-26 11:25:07	10
5	133	yes	1	perfumes	120x130	20	100	24548	2023-10-26 11:32:48	2023-10-26 11:32:48	5
6	134	yes	1	Car accesories	160X160	20	100	234	2023-10-26 11:36:57	2023-10-26 11:36:57	20
7	135	\N	1	Car accesories	160X160	250	25	250	2023-10-26 11:41:11	2023-10-26 11:41:11	20
8	136	yes	2	Clothes	2x3x2	20	20	4000	2023-10-26 11:52:55	2023-10-26 11:52:55	20
9	137	yes	2	Clothes	2x3x2	20	20	4000	2023-10-26 11:58:14	2023-10-26 11:58:14	20
10	138	yes	2	accessories	120x139	10	100	400000	2023-10-26 12:21:35	2023-10-26 14:50:13	48
11	156	yes	2	12	34	2	25	125	2023-10-26 17:17:17	2023-10-26 17:17:17	25
12	198	yes	1	ffggg	45566	666555	55555	2555	2023-11-13 13:37:28	2023-11-13 13:37:28	55666
13	214	yes	2	test ware	2x2x2	3	6	600	2023-11-13 14:25:23	2023-11-13 14:25:23	2
14	215	yes	2	test ware one	2x2x2	3	6	600	2023-11-13 14:28:20	2023-11-13 14:28:20	2
15	216	yes	2	test ware two	2x2x2	3	6	600	2023-11-13 14:28:43	2023-11-13 14:28:43	2
16	231	yes	2	test warehouse	2x3x4	3	36	3258	2023-11-13 23:35:58	2023-11-13 23:35:58	12
17	232	yes	1	test	55	55	55	55	2023-11-14 09:54:39	2023-11-14 09:54:39	5
18	233	yes	2	Test	44	88	6	44	2023-11-14 10:25:33	2023-11-14 11:52:46	5
\.


--
-- Name: accepted_qoutes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.accepted_qoutes_id_seq', 45, true);


--
-- Name: addresses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.addresses_id_seq', 77, true);


--
-- Name: app_settings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.app_settings_id_seq', 1, false);


--
-- Name: blacklists_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.blacklists_id_seq', 1, true);


--
-- Name: booking_additional_charges_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_additional_charges_id_seq', 1, false);


--
-- Name: booking_carts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_carts_id_seq', 317, true);


--
-- Name: booking_containers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_containers_id_seq', 1, false);


--
-- Name: booking_deligate_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_deligate_details_id_seq', 44, true);


--
-- Name: booking_qoutes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_qoutes_id_seq', 100, true);


--
-- Name: booking_reviews_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_reviews_id_seq', 7, true);


--
-- Name: booking_status_trackings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_status_trackings_id_seq', 258, true);


--
-- Name: booking_truck_alots_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_truck_alots_id_seq', 100, true);


--
-- Name: booking_truck_carts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_truck_carts_id_seq', 247, true);


--
-- Name: booking_trucks_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_trucks_id_seq', 208, true);


--
-- Name: bookings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bookings_id_seq', 240, true);


--
-- Name: cart_deligate_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cart_deligate_details_id_seq', 56, true);


--
-- Name: cart_warehousing_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cart_warehousing_details_id_seq', 19, true);


--
-- Name: cities_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cities_id_seq', 2, true);


--
-- Name: companies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.companies_id_seq', 2, true);


--
-- Name: containers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.containers_id_seq', 4, true);


--
-- Name: countries_country_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.countries_country_id_seq', 1, true);


--
-- Name: country_languages_country_lang_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.country_languages_country_lang_id_seq', 1, false);


--
-- Name: deligate_attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.deligate_attributes_id_seq', 1, false);


--
-- Name: deligates_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.deligates_id_seq', 4, true);


--
-- Name: driver_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.driver_details_id_seq', 47, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: faq_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.faq_id_seq', 1, false);


--
-- Name: help_request_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.help_request_id_seq', 9, true);


--
-- Name: languages_language_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.languages_language_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 148, true);


--
-- Name: notification_users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notification_users_id_seq', 2, true);


--
-- Name: notifications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notifications_id_seq', 1, true);


--
-- Name: pages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pages_id_seq', 8, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 558, true);


--
-- Name: role_permissions_permission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.role_permissions_permission_id_seq', 7, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 5, true);


--
-- Name: settings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.settings_id_seq', 1, true);


--
-- Name: shipping_methods_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.shipping_methods_id_seq', 1, true);


--
-- Name: storage_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.storage_types_id_seq', 3, true);


--
-- Name: temp_users_temp_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.temp_users_temp_user_id_seq', 270, true);


--
-- Name: truck_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.truck_types_id_seq', 7, true);


--
-- Name: user_password_resets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_password_resets_id_seq', 1, false);


--
-- Name: user_wallet_transactions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_wallet_transactions_id_seq', 1, false);


--
-- Name: user_wallets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_wallets_id_seq', 1, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 146, true);


--
-- Name: warehousing_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.warehousing_details_id_seq', 18, true);


--
-- Name: accepted_qoutes accepted_qoutes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accepted_qoutes
    ADD CONSTRAINT accepted_qoutes_pkey PRIMARY KEY (id);


--
-- Name: addresses addresses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.addresses
    ADD CONSTRAINT addresses_pkey PRIMARY KEY (id);


--
-- Name: app_settings app_settings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.app_settings
    ADD CONSTRAINT app_settings_pkey PRIMARY KEY (id);


--
-- Name: blacklists blacklists_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.blacklists
    ADD CONSTRAINT blacklists_pkey PRIMARY KEY (id);


--
-- Name: booking_additional_charges booking_additional_charges_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_additional_charges
    ADD CONSTRAINT booking_additional_charges_pkey PRIMARY KEY (id);


--
-- Name: booking_carts booking_carts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_carts
    ADD CONSTRAINT booking_carts_pkey PRIMARY KEY (id);


--
-- Name: booking_containers booking_containers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_containers
    ADD CONSTRAINT booking_containers_pkey PRIMARY KEY (id);


--
-- Name: booking_deligate_details booking_deligate_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_deligate_details
    ADD CONSTRAINT booking_deligate_details_pkey PRIMARY KEY (id);


--
-- Name: booking_qoutes booking_qoutes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_qoutes
    ADD CONSTRAINT booking_qoutes_pkey PRIMARY KEY (id);


--
-- Name: booking_reviews booking_reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_reviews
    ADD CONSTRAINT booking_reviews_pkey PRIMARY KEY (id);


--
-- Name: booking_status_trackings booking_status_trackings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_status_trackings
    ADD CONSTRAINT booking_status_trackings_pkey PRIMARY KEY (id);


--
-- Name: booking_truck_alots booking_truck_alots_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_truck_alots
    ADD CONSTRAINT booking_truck_alots_pkey PRIMARY KEY (id);


--
-- Name: booking_truck_carts booking_truck_carts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_truck_carts
    ADD CONSTRAINT booking_truck_carts_pkey PRIMARY KEY (id);


--
-- Name: booking_trucks booking_trucks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_trucks
    ADD CONSTRAINT booking_trucks_pkey PRIMARY KEY (id);


--
-- Name: bookings bookings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bookings
    ADD CONSTRAINT bookings_pkey PRIMARY KEY (id);


--
-- Name: cart_deligate_details cart_deligate_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_deligate_details
    ADD CONSTRAINT cart_deligate_details_pkey PRIMARY KEY (id);


--
-- Name: cart_warehousing_details cart_warehousing_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_warehousing_details
    ADD CONSTRAINT cart_warehousing_details_pkey PRIMARY KEY (id);


--
-- Name: cities cities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cities
    ADD CONSTRAINT cities_pkey PRIMARY KEY (id);


--
-- Name: companies companies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_pkey PRIMARY KEY (id);


--
-- Name: containers containers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.containers
    ADD CONSTRAINT containers_pkey PRIMARY KEY (id);


--
-- Name: countries countries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_pkey PRIMARY KEY (country_id);


--
-- Name: country_languages country_languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.country_languages
    ADD CONSTRAINT country_languages_pkey PRIMARY KEY (country_lang_id);


--
-- Name: deligate_attributes deligate_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligate_attributes
    ADD CONSTRAINT deligate_attributes_pkey PRIMARY KEY (id);


--
-- Name: deligates deligates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligates
    ADD CONSTRAINT deligates_pkey PRIMARY KEY (id);


--
-- Name: driver_details driver_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.driver_details
    ADD CONSTRAINT driver_details_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: faq faq_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.faq
    ADD CONSTRAINT faq_pkey PRIMARY KEY (id);


--
-- Name: help_request help_request_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.help_request
    ADD CONSTRAINT help_request_pkey PRIMARY KEY (id);


--
-- Name: languages languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_pkey PRIMARY KEY (language_id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: notification_users notification_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification_users
    ADD CONSTRAINT notification_users_pkey PRIMARY KEY (id);


--
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- Name: pages pages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages
    ADD CONSTRAINT pages_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: role_permissions role_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_permissions
    ADD CONSTRAINT role_permissions_pkey PRIMARY KEY (permission_id);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: settings settings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_pkey PRIMARY KEY (id);


--
-- Name: shipping_methods shipping_methods_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shipping_methods
    ADD CONSTRAINT shipping_methods_pkey PRIMARY KEY (id);


--
-- Name: storage_types storage_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.storage_types
    ADD CONSTRAINT storage_types_pkey PRIMARY KEY (id);


--
-- Name: temp_users temp_users_driving_license_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_users
    ADD CONSTRAINT temp_users_driving_license_number_unique UNIQUE (driving_license_number);


--
-- Name: temp_users temp_users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_users
    ADD CONSTRAINT temp_users_email_unique UNIQUE (email);


--
-- Name: temp_users temp_users_phone_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_users
    ADD CONSTRAINT temp_users_phone_unique UNIQUE (phone);


--
-- Name: temp_users temp_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_users
    ADD CONSTRAINT temp_users_pkey PRIMARY KEY (temp_user_id);


--
-- Name: truck_types truck_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.truck_types
    ADD CONSTRAINT truck_types_pkey PRIMARY KEY (id);


--
-- Name: user_password_resets user_password_resets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_password_resets
    ADD CONSTRAINT user_password_resets_pkey PRIMARY KEY (id);


--
-- Name: user_wallet_transactions user_wallet_transactions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallet_transactions
    ADD CONSTRAINT user_wallet_transactions_pkey PRIMARY KEY (id);


--
-- Name: user_wallets user_wallets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallets
    ADD CONSTRAINT user_wallets_pkey PRIMARY KEY (id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: warehousing_details warehousing_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.warehousing_details
    ADD CONSTRAINT warehousing_details_pkey PRIMARY KEY (id);


--
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: user_password_resets_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX user_password_resets_email_index ON public.user_password_resets USING btree (email);


--
-- Name: accepted_qoutes accepted_qoutes_booking_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accepted_qoutes
    ADD CONSTRAINT accepted_qoutes_booking_id_foreign FOREIGN KEY (booking_id) REFERENCES public.bookings(id) ON DELETE CASCADE;


--
-- Name: accepted_qoutes accepted_qoutes_driver_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accepted_qoutes
    ADD CONSTRAINT accepted_qoutes_driver_id_foreign FOREIGN KEY (driver_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: booking_containers booking_containers_booking_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_containers
    ADD CONSTRAINT booking_containers_booking_id_foreign FOREIGN KEY (booking_id) REFERENCES public.bookings(id) ON DELETE CASCADE;


--
-- Name: booking_deligate_details booking_deligate_details_booking_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_deligate_details
    ADD CONSTRAINT booking_deligate_details_booking_id_foreign FOREIGN KEY (booking_id) REFERENCES public.bookings(id) ON DELETE CASCADE;


--
-- Name: booking_qoutes booking_qoutes_booking_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_qoutes
    ADD CONSTRAINT booking_qoutes_booking_id_foreign FOREIGN KEY (booking_id) REFERENCES public.bookings(id) ON DELETE CASCADE;


--
-- Name: booking_qoutes booking_qoutes_driver_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_qoutes
    ADD CONSTRAINT booking_qoutes_driver_id_foreign FOREIGN KEY (driver_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: booking_reviews booking_reviews_booking_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_reviews
    ADD CONSTRAINT booking_reviews_booking_id_foreign FOREIGN KEY (booking_id) REFERENCES public.bookings(id) ON DELETE CASCADE;


--
-- Name: booking_trucks booking_trucks_booking_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_trucks
    ADD CONSTRAINT booking_trucks_booking_id_foreign FOREIGN KEY (booking_id) REFERENCES public.bookings(id) ON DELETE CASCADE;


--
-- Name: bookings bookings_sender_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bookings
    ADD CONSTRAINT bookings_sender_id_foreign FOREIGN KEY (sender_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: deligate_attributes deligate_attributes_deligate_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligate_attributes
    ADD CONSTRAINT deligate_attributes_deligate_id_foreign FOREIGN KEY (deligate_id) REFERENCES public.deligates(id) ON DELETE CASCADE;


--
-- Name: driver_details driver_details_truck_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.driver_details
    ADD CONSTRAINT driver_details_truck_type_id_foreign FOREIGN KEY (truck_type_id) REFERENCES public.truck_types(id) ON DELETE CASCADE;


--
-- Name: driver_details driver_details_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.driver_details
    ADD CONSTRAINT driver_details_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: user_wallets user_wallets_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallets
    ADD CONSTRAINT user_wallets_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: users users_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: warehousing_details warehousing_details_booking_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.warehousing_details
    ADD CONSTRAINT warehousing_details_booking_id_foreign FOREIGN KEY (booking_id) REFERENCES public.bookings(id) ON DELETE CASCADE;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE USAGE ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

